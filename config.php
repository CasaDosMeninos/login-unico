<?php

/*
======================================
=                                    =
=  Configurações de Administrador    =
=                                    =
======================================
Edite todas as configurações!
*/

// Configurações de domínio
define('DOMAIN', 'login.casadosmeninos.org.br');

// Configurações de e-mail
define('SMTP_HOST', 'mailtrap.io');
define('SMTP_PORT', 2525);
define('SMTP_USER', '4016795a2963175a2');
define('SMTP_PASSWORD', '83ce7e6e1b110c');

// Configurações deste Painel
define('ADM_USER', 'admin');
define('ADM_PASSWORD', '123');

// Configurações do Servidor LDAP
define('LDAP_HOST', 'cmweb');
define('LDAP_SUFFIX', 'dc=intranet,dc=cm,dc=net');
define('LDAP_USER', 'admin');
define('LDAP_PASSWORD', '123');
define('LDAP_SEARCH', 'ou=People,dc=intranet,dc=cm,dc=net');
define('LDIF_PATH', 'ldifs/');

/*
======================================
=                                    =
=         Funções adicionais         =
=                                    =
======================================
NÃO MEXER AQUI!!!
*/

function conecta() {
    $ldapConn = ldap_connect(LDAP_HOST) or die("Não foi possível se conectar ao LDAP: " . LDAP_HOST);

    // Set some ldap options for talking to AD
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

    //this is the LDAP admin account with access
    $adminUsername = "cn=" . LDAP_USER . "," . LDAP_SUFFIX;

    // Bind as a domain admin if they've set it up
    ldap_bind($ldapConn, $adminUsername, LDAP_PASSWORD) or die("Não foi possível se conectar ao LDAP: Credenciais inválidas");

    return $ldapConn;
}

function procura($dn, $filter) {
    $con = conecta();
    // DN: "uid=$email,ou=People,dc=intranet,dc=cm,dc=net"
    // Filter: (userPassword=$pass)
    $search = ldap_search($con,$dn,$filter) or die('Não foi possível completar a busca no LDAP');

    $info = ldap_get_entries($con, $search);
    ldap_close($con);
    return $info;
}

function adiciona($data) {
    // Escreve LDIF da pessoa
    if (!file_exists(LDIF_PATH))
        mkdir(LDIF_PATH, null, true);
    $fp = fopen(LDIF_PATH . '/' . $data['cn'] . '.ldif', 'a');
    fprintf($fp, "dn: uid={$data['uid']}," . LDAP_SEARCH . "\n") ;
    foreach($data as $k => $v) {
        if (strtolower($k) == 'objectclass')
            foreach ($v as $class)
                fprintf($fp, "objectClass: $class\n");
        else
            fprintf($fp, "$k: $v\n");
    }
    fclose($fp);

    $con = conecta();
    $dn = "uid={$data['uid']}," . LDAP_SEARCH;
    $info = ldap_add($con, $dn, $data);
    ldap_close($con);
    return $info;
}

function ativa($uid) {
    $con = conecta();
    $info = ldap_modify($con, "uid=$uid,ou=People,dc=intranet,dc=cm,dc=net", ['validado' => 'TRUE']);
    ldap_close($con);
    return $info;
}

function deleta($uid) {
    $con = conecta();
    ldap_delete($con, "uid=$uid,ou=People,dc=intranet,dc=cm,dc=net");
    ldap_close($con);
}

function email($data) {
    require_once 'email/Emailer.php';
    require_once 'email/EmailTemplate.php';

    $Emailer = new Emailer($data['uid']);

    $Template = new EmailTemplate('email/basic.php');
    $Template->nome = $data['cn'];
    $Template->url= DOMAIN . '/ativa.php?uid=' . $data['uid'];

    $Emailer->SetTemplate($Template); //Email runs the compile
    $Emailer->send();
}
?>