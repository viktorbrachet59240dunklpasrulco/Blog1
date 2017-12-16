<?php
/* Smarty version 3.1.30, created on 2017-12-16 14:07:54
  from "C:\xampp\htdocs\Blog\templates\inscription.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a351aaa2fa383_28251539',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3be00a4ca3bde9d556ae8244e7d9605eb7d43f20' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Blog\\templates\\inscription.tpl',
      1 => 1513428101,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a351aaa2fa383_28251539 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--
* Page html inscription utilisateur
*
* Contenu :
* 
* Formulaire d'inscription utilisateur

*
* inscription.php est le contrôleur
* inscription.tpl est la vue
-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="mt-5">Créer un compte utilisateur</h1>
                <br/>
                <!-- On récupère une notification s'il elle n'est pas vide -->            
                <?php if ($_smarty_tpl->tpl_vars['notification']->value != '') {?>
                <!-- On définit la couleur de la notification -->                
                <div class="alert <?php echo $_smarty_tpl->tpl_vars['notification_result']->value;?>
 alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <!-- On définit le texte de la notification -->                
                <?php echo $_smarty_tpl->tpl_vars['notification']->value;?>
              
                </div>
                <?php }?>
                <form action="inscription.php" method="post" enctype="multipart/form-data" id="form-inscription">
                    <div class="form-group">
                      <label for="nom">Nom :</label>
                      <input  type="texte" class="form-control" name="nom" id="nom" placeholder="Veuillez saisir votre nom" required>
                    </div>
                    <div class="form-group">
                      <label for="prenom">Prénom :</label>
                      <input  type="texte" class="form-control" name="prenom" id="prenom" placeholder="Veuillez saisir votre prénom" required>
                    </div>
                    <div class="form-group">
                      <label for="email">Adresse email :</label>
                      <input  type="email" class="form-control" name="email" id="email" placeholder="Veuillez saisir votre email" required>
                    </div>
                    <div class="form-group">
                      <label for="mdp">Mot de passe :</label>
                      <input  type="password" class="form-control" name="mdp" id="mdp" placeholder="Veuillez saisir votre mot de passe" required>
                    </div>                
                    <button type="submit" name="submit" class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
            
            
    <!-- Bootstrap core JavaScript -->
    <?php echo '<script'; ?>
 src="vendor/jquery/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="vendor/popper/popper.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="vendor/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/dist/jquery.validate.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/dist/localization/messages_fr.min.js"><?php echo '</script'; ?>
>   
        
    

<?php }
}
