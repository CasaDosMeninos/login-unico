@extends('layout.master')

@section('content')

    <?php if (isset($erro)) { ?>
    <div class="alert alert-danger">
        <strong>Erro!</strong> Login Inválido
    </div>
    <?php } ?>

    <form class="form-horizontal" action="{{ route('admin') }}" method="post">
        <fieldset>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="email">E-mail</label>
                <div class="col-md-4">
                    <input name="email" class="form-control input-md" id="email" required="" type="text">
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="senha">Senha</label>
                <div class="col-md-4">
                    <input name="senha" class="form-control input-md" id="senha" required="" type="password">

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