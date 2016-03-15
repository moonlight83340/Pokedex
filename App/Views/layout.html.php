<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?= htmlentities($title)?></title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name = " author " content = "Gaëtan Perrot" >
        <meta name = " keywords " content = "<?= htmlentities($keywords) ?>">
        <meta name = " description " content = "<?= htmlentities($description)?>">
        <link href="/Resources/Bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="icon" type="image/png" href="/Resources/Images/pokeball.png" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/Resources/Bootstrap/js/bootstrap.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav id="navbar-pokedex" class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                    <a id="navbar-brand-pokedex" class="navbar-brand" href="<?= \PoireauFramework\Helper\Url::base()?>">Pokiut Api Pokedex</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul id="navbar-left-pokedex" class="nav navbar-nav">
                        <li><a href="#">Mini-jeux</a></li>
                        <li><a href="#">Pokedex</a></li>
                    </ul>
                    <form id="form-connexion-inscription-pokedex" class="navbar-form navbar-right">
                        <div class="form-group">
                          <input placeholder="Pseudo" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                          <input placeholder="Password" class="form-control" type="password">
                        </div>
                        <button id="bouton-connexion-pokedex" type="submit" class="btn btn-success">Connexion</button>
                        <button id="bouton-inscription-pokedex" type="button" class="btn btn-success" data-toggle="modal" data-target="#RegisterModal"><span class="glyphicon glyphicon-user"></span> Inscription</button>
                    </form>
                </div><!--/.navbar-collapse -->         
            </div>
        </nav>
        <div class="modal fade" id="RegisterModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pokiut Api Pokedex, inscription</h4>
                    </div>
                    <div class="modal-body">
                      <div id="page-content-wrapper">
                          <div class="container-fluid">
                              <div class="row">
                                  <div class="col-lg-4-fixed">
                                        <h2 class="text-center">Inscription</h2> 
                                      <form id="registerForm" role="form" method="post" onsubmit="return validateForm()" action="<?= \PoireauFramework\Helper\Url::base().'account/register'?>">                                         
                                        <div id="pseudoDiv" class="form-group">
                                            <label class="control-label" for="pseudo">Pseudo :</label>
                                            <input type="text" name = "pseudo" class="form-control" id="register-pseudo">
                                        </div>

                                        <div id="emailDiv" class="form-group">
                                            <label class="control-label" for="email">Adresse email :</label>
                                            <input type="email" name = "email" class="form-control" id="register-email">
                                        </div>

                                        <div id="passwordDiv" class="form-group">
                                            <label class="control-label" for="pwd">Mot de passe :</label>
                                            <input type="password" name = "password" class="form-control" id="pwd">
                                        </div>

                                        <div id="passwordConfirmDiv" class="form-group">
                                            <label class="control-label" for="pwdConfirm">Confirmer mot de passe :</label>
                                            <input type="password" name = "passwordConfirm" class="form-control" id="pwdConfirm">
                                        </div>
                                        <div class="text-center">
                                          <button type="submit" class="btn btn-default">Créer son compte !</button>
                                        </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                          <button type="button" class="btn btn-default register-button" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <div id='pokedex-title'>
            <h1 class="text-center">Pokiut Api Pokedex, Le pokedex du pika'ddicts</h1>
        </div>
        <?= $contents ?>
        <footer>
            <p class="text-center"><a href="#">Haut de page </a> ©  Pokiut Api Pokedex 2016</p>
        </footer>
    </body>
</html>
