<?php
/* Smarty version 3.1.30, created on 2017-12-16 13:39:31
  from "C:\xampp\htdocs\Blog\templates\connexion.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a35140304cbb1_93014110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3917367e3c1d1aa56caa7d47a03d966e0ff95dd9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Blog\\templates\\connexion.tpl',
      1 => 1513427106,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a35140304cbb1_93014110 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--
* Page html connexion utilisateur
*
* Contenu :
* 
* Formulaire de connexion utilisateur

*
* connexion.php est le contrôleur
* connexion.tpl est la vue
-->

    <!-- Page Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
            <h1 class="mt-5">Connexion Utilisateur</h1>
            
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
                <form action="connexion.php" method="post" enctype="multipart/form-data" id="form-connexion">
                    <div class="form-group">
                    <label for="email">Adresse email :</label>
                    <input  type="email" class="form-control" name="email" id="email" placeholder="Veuillez saisir votre email" required>
                    </div>
                    <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input  type="password" class="form-control" name="mdp" id="mdp" placeholder="Veuillez saisir votre mot de passe" required>
                    </div>                
                <button type="submit" name="submit" class="btn btn-primary">Se connecter</button>
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
