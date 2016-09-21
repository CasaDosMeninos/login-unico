@extends('layout.master')

@section('content')

    @if(isset($_SESSION['error']) && $_SESSION['error'] == 1)
    <div class="alert alert-danger">
        <strong>Erro!</strong> Este e-mail já foi cadastrado anteriormente
    </div>
    <?php unset($_SESSION['error']); ?>
    @endif

    @if(isset($_SESSION['success']) && $_SESSION['success'] == 1)
    <div class="alert alert-success">
        <strong>Sucesso!</strong> Você receberá um e-mail em instantes para ativar sua conta.
    </div>
    <?php unset($_SESSION['success']); ?>
    @endif


    <form class="form-horizontal" data-toggle="validator" action="" method="post">
        <fieldset>
            <!-- Nome Completo -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="nome">Nome</label>
                <div class="col-md-4">
                    <input name="nome" class="form-control input-md" id="nome" required data-error="Este campo é obrigatório" type="text">
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="email">E-mail</label>
                <div class="col-md-4">
                    <input name="email" class="form-control input-md" id="email" required data-error="Entre com um e-mail válido" type="email">
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <!-- Senha -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="senha">Senha</label>
                <div class="col-md-4">
                    <input name="senha" class="form-control input-md" data-minlength="6" id="senha" required type="password">
                    <span class="help-block">No mínimo 6 caracteres</span>
                </div>
            </div>

            <!-- Telefone 1 -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="telefone">Telefone</label>
                <div class="col-md-4">
                    <input pattern="[0-9]{8,}" name="telefone" class="form-control input-md" id="telefone" required="" type="text">
                    <span class="help-block">Apenas dígitos</span>
                </div>
            </div>

            <!-- Telefone 2 -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="telefone2">Telefone 2</label>
                <div class="col-md-4">
                    <input name="telefone2" class="form-control input-md" id="telefone2" type="text">
                    <span class="help-block">Apenas dígitos</span>
                </div>
            </div>

            <!-- Endereço -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="endereco">Endereço</label>
                <div class="col-md-4">
                    <input name="endereco" class="form-control input-md" id="endereco" type="text" required>
                    <span class="help-block">Ex.: Rua Teodoro Sampaio, 88</span>
                </div>
            </div>

            <!-- CEP -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="cep">CEP</label>
                <div class="col-md-4">
                    <input data-mask="00000-000" name="cep" class="form-control input-md" id="cep" type="text" required>
                    <span class="help-block">Apenas dígitos</span>
                </div>
            </div>

            <!-- Data de Nascimento -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="nascimento">Data de Nascimento</label>
                <div class="col-md-4">
                    <input data-mask="00/00/0000" name="nascimento" class="form-control input-md" id="nascimento" required="" type="text">
                    <span class="help-block">Apenas dígitos</span>
                </div>
            </div>

            <!-- É estudante? -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="categoria">Categoria</label>
                <div class="col-md-4">
                    <select name="categoria" id="categoria">
                        <option value="estudante">Estudante</option>
                        <option value="professor">Professor</option>
                        <option value="nenhuma" selected="selected">Nenhuma</option>
                    </select>
                </div>
            </div>

            <!-- Escola -->
            <div class="form-group escola">
                <label class="col-md-4 control-label" for="escola">Nome da escola</label>
                <div class="col-md-4">
                    <input name="escola" class="form-control input-md" id="escola" type="text">
                </div>
            </div>

            <!-- Serie -->
            <div class="form-group serie">
                <label class="col-md-4 control-label" for="serie">Qual série?</label>
                <div class="col-md-4">
                    <select name="serie" id="">
                        <option value="0" selected>Selecione</option>
                        <option value="1">1ª Série</option>
                        <option value="2">2ª Série</option>
                        <option value="3">3ª Série</option>
                        <option value="4">4ª Série</option>
                        <option value="5">5ª Série</option>
                        <option value="6">6ª Série</option>
                        <option value="7">7ª Série</option>
                        <option value="8">8ª Série</option>
                        <option value="9">9ª Série</option>
                        <option value="10">1º Colegial</option>
                        <option value="11">2º Colegial</option>
                        <option value="12">3º Colegial</option>
                    </select>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-4">
                    <button name="submit" class="btn btn-primary" id="submit">Enviar</button>
                </div>
            </div>

        </fieldset>
    </form>
@endsection

@push('scripts')
<script src="/js/validator.js"></script>
<script src="/js/mask.js"></script>
<script type="text/javascript">
    $('#categoria').change(function() {
        if ($(this).val() == 'nenhuma') {
            $('.escola, .serie').hide();
        }
        else if($(this).val() == 'estudante') {
            $('.escola, .serie').show();
        }
        else if($(this).val() == 'professor') {
            $('.escola').show();
            $('.serie').hide();
        }
    }).change();
    $.mask
</script>
@endpush