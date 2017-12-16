<?php
/* Smarty version 3.1.30, created on 2017-12-16 14:07:49
  from "C:\xampp\htdocs\Blog\templates\article.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a351aa5211829_63970259',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '715f9510b47f0c5b514cfffd6245711faa1d6ca6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Blog\\templates\\article.tpl',
      1 => 1513428190,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a351aa5211829_63970259 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--
* Page html modifier ou ajouter un article
*
* Contenu :
* 
* Formulaire d'ajout et de modification d'un article

*
* article.php est le contrôleur
* article.tpl est la vue
-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <!-- On définit si l'on doit modifier ou ajouter un article -->
                <h1 class="mt-5"><?php if ($_smarty_tpl->tpl_vars['action']->value == "modifier") {?>
                Modifier un article
                <?php } else { ?>
                Ajouter un article
                <?php }?>
                </h1>
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
          
                <form action="article.php" method="post" enctype="multipart/form-data" id="form-article">

                    <!--On stocke l'id article récupéré par l'article à modifier  -->
                    <input type="hidden" name="store_id_article" id="store_id_article" value="<?php echo $_smarty_tpl->tpl_vars['id_article']->value;?>
" />

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <!-- On place les valeurs dans les champs (titre ect...) par défaut elles sont vides (voir article.php), elles ne sont pas vides lorsque l'on
                        fait une modification d'article -->
                        <input  type="texte" class="form-control" name="titre" id="titre" value="<?php echo $_smarty_tpl->tpl_vars['titre']->value;?>
" placeholder="Veuillez choisir un titre" required>
                    </div>
                    <div class="form-group">
                        <label for="texte">Insérer le texte de votre article</label>
                        <textarea  class="form-control" id="texte" name="texte" rows="3" required><?php echo $_smarty_tpl->tpl_vars['texte']->value;?>
</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Insérer une image</label>
                        <?php if ($_smarty_tpl->tpl_vars['action']->value == "modifier" && $_smarty_tpl->tpl_vars['id_article']->value != '') {?>
                        <!-- si l'on modifie un article alors on affiche l'image de l'article -->
                        <img  src="img\<?php echo $_smarty_tpl->tpl_vars['id_article']->value;?>
.jpg?<?php echo $_smarty_tpl->tpl_vars['time']->value;?>
" style="width: 20rem;"> 
                        <input type="file" name="image" class="form-control-file" id="image">
                        <?php } else { ?>
                        <!-- sinon on affiche juste l'input pour upload un fichier -->
                        <input type="file" name="image" class="form-control-file" id="image" required>          
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label" for="publie">
                            <?php if ($_smarty_tpl->tpl_vars['action']->value == "modifier" && $_smarty_tpl->tpl_vars['publie']->value == 1) {?>
                            <!-- si l'on modifie un article alors par défaut on coche la case publie -->
                            <input class="form-check-input" id="publie" value=1 name="publie" checked type="checkbox"> Publier?
                            <?php } else { ?>
                            <!-- sinon ne coche pas la case -->
                            <input class="form-check-input" id="publie" value=1 name="publie" type="checkbox"> Publier?	
                            <?php }?>	
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="submit" value="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="btn btn-primary">
                        <?php if ($_smarty_tpl->tpl_vars['action']->value == "modifier") {?>
                        <!-- si l'on modifie un article alors on affiche Modifier sur le bouton submit -->
                        Modifier
                        <?php } else { ?>
                        <!-- sinon on affiche Ajouter sur le bouton submit -->
                        Ajouter
                        <?php }?>
                    </button>
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
