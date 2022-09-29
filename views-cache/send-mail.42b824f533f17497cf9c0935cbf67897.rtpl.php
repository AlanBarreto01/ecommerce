<?php if(!class_exists('Rain\Tpl')){exit;}?><html>
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    	<link rel="stylesheet" href="/res/admin/bootstrap/css/bootstrap.min.css">
	    <!-- Font Awesome -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	    <!-- Ionicons -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	    <!-- Theme style -->
	    <link rel="stylesheet" href="/res/admin/dist/css/AdminLTE.min.css">


	</head>

	<body>

		<div class="container">  

			<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="/views/admin/logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>

      		<div class="row">
      			<div class="col-md-12">
  				
					<div class="card-body font-weight-bold">
						<form action="/views/admin/processa_envio.php" method="post"><!--Para onde o formulário é enviado e qual Método-->
							<div class="form-group">
								<label for="para">Para</label>
								<input name="email" type="text" class="form-control" id="email" placeholder="Digite seu email">
							</div>

							<div class="form-group">
								<label for="assunto">Assunto</label>
								<input name="assunto" type="text" class="form-control" id="assunto" placeholder="Assundo do e-mail">
							</div>

							<div class="form-group">
								<label for="mensagem">Mensagem</label>
								<textarea name="mensagem" class="form-control" id="mensagem"></textarea>
							</div>

							<button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
						</form>
					</div>
				</div>
      		</div>
      	</div>

	</body>
</html>