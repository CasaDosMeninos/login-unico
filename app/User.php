<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Exception;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $guarded = [];

    public static function valida($email) {
        $data = self::procura($email);
        return $data['count'] == 0;
    }

    public static function ativa($email) {
        $ldap = app('ldap');
        $base_dn = env('LDAP_BASE_DN');
        $dn = "uid={$email},ou=People,{$base_dn}";

        $info = ldap_modify($ldap, $dn, ['validado' => 'TRUE']);
        ldap_close($ldap);
        return $info;
    }

    public static function deleta($email) {
        $ldap = app('ldap');
        $base_dn = env('LDAP_BASE_DN');
        $dn = "uid={$email},ou=People,{$base_dn}";

        $success = ldap_delete($ldap, $dn);
        ldap_close($ldap);

        if (!$success) throw new Exception('Erro ao deletar usuario');
        return $success;
    }

    public static function procura($email) {
        $ldap = app('ldap');
        $base_dn = env('LDAP_BASE_DN');
        $dn = "ou=People,{$base_dn}";
        $search = ldap_search($ldap,$dn,"uid=$email");
        return ldap_get_entries($ldap, $search);
    }

    public function prepareLDAP() {
        $data['objectClass'][0] = 'userControl';
        $data['objectClass'][1] = 'inetOrgPerson';
//        $data['objectClass'][2] = 'PosixAccount';

        $data['cn'] = $data['sn'] = $this->nome;
        $data['uid'] = $data['mail'] = $this->email;

        $data['mobile'] = $this->telefone;
        $data['homePhone'] = $this->telefone2;
        $data['homePostalAddress'] = $this->endereco;
        $data['postalCode'] = $this->cep;
        $data['senha'] = md5($this->senha);
        $data['birthdate'] = $this->nascimento;

        $data['categoria'] = $this->categoria;
        switch($this->categoria) {
            case 'estudante':
                $data['serie'] = $this->serie;
            case 'professor':
                $data['escola'] = $this->escola;
                break;
            default:
        }

        $this->ldif = $data;
    }

    public function writeLDIF() {
        $this->prepareLDAP();

        // Cria diretorio e abre arquivo para escrita
        if (!file_exists(env('LDIF_PATH')))
            mkdir(env('LDIF_PATH'), null, true);
        $fp = fopen(env('LDIF_PATH') . '/' . $this->ldif['cn'] . '.ldif', 'w');

        // Não conseguiu escrever o arquivo
        if ($fp == false) return -1;

        $base_dn = env('LDAP_BASE_DN');
        fprintf($fp, "dn: uid={$this->ldif['uid']},ou=People,{$base_dn}\n") ;
        foreach($this->ldif as $k => $v) {
            if (strtolower($k) == 'objectclass')
                foreach ($v as $class)
                    fprintf($fp, "objectClass: $class\n");
            else
                fprintf($fp, "$k: $v\n");
        }
        fclose($fp);
    }

    public function cadastra() {
        $this->writeLDIF();
        $ldap = app('ldap');

        $base_dn = env('LDAP_BASE_DN');
        $dn = "uid={$this->ldif['uid']},ou=People,{$base_dn}";

        $success = ldap_add($ldap, $dn, $this->ldif);
        ldap_close($ldap);
        return $success;
    }

    public static function withData($email) {
        $data = self::procura($email);

        if ($data['count'] != 1) throw new Exception('Usuario não existe');
        else $data = $data[0];

        $user = new User();

        $user->nome = $data['sn'][0];
        $user->email = $data['mail'][0];
        $user->telefone = $data['mobile'][0];
        $user->telefone2 = $data['homephone'][0];
        $user->endereco = $data['homepostaladdress'][0];
        $user->cep = $data['postalcode'][0];
        $user->nascimento = $data['birthdate'][0];
        $user->categoria = $data['categoria'][0];
        switch($user->categoria) {
            case 'estudante':
                $user->serie = $data['serie'][0];
            case 'professor':
                $user->escola = $data['escola'][0];
            default:
        }
        if (isset($data['validado'])) $user->validado = true;
        else $user->validado = false;

        return $user;
    }







}
