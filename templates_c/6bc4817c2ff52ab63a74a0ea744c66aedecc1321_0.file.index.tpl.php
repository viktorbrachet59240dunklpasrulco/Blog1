<?php
/* Smarty version 3.1.30, created on 2017-12-16 14:23:38
  from "C:\xampp\htdocs\Blog\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a351e5ab0fb86_82501823',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6bc4817c2ff52ab63a74a0ea744c66aedecc1321' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Blog\\templates\\index.tpl',
      1 => 1513430438,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a351e5ab0fb86_82501823 (Smarty_Internal_Template $_smarty_tpl) {
?>
 <!--
* Page html afficher un article
*
* Contenu :
* 
* Formulaire de création de commentaire
* Affichage des articles
*
* index.php est le contrôleur
* index.tpl est la vue
--> 


    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Articles publiés</h1>
                <ul class="list-unstyled">
                    <li>du plus récent au plus ancien</li>
                </ul>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['notification']->value != '') {?>
        <div class="alert <?php echo $_smarty_tpl->tpl_vars['notification_result']->value;?>
 alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        <?php echo $_smarty_tpl->tpl_vars['notification']->value;?>
              
        </div>
        <?php }?>
        <br/>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab_articles']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
        <!-- Pour chaque article, on associe ses valeurs -->
        <div class="row justify-content-center"> 
            <div class="card col-md-10">
                <img class="card-img-top" src="img/<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
.jpg?<?php echo $_smarty_tpl->tpl_vars['time']->value;?>
"  style="width: 20rem;">
                
                <div class="card-body">
                    <h4 class="card-title">
                        <?php echo $_smarty_tpl->tpl_vars['value']->value['titre'];?>
 
                        <br/>
                    </h4>
                            
                    <p class="card-text">
                        <?php echo $_smarty_tpl->tpl_vars['value']->value['texte'];?>

                    </p>
                    <button class="btn btn-primary">
                        Crée le <?php echo $_smarty_tpl->tpl_vars['value']->value['date_fr'];?>

                    </button>
                    <?php if ($_smarty_tpl->tpl_vars['is_connect']->value == "TRUE") {?>
                    <!-- si l'utilisateur est connecté alors il peut voir le bouton modifier l'article -->
                    <a href="article.php?action=modifier&id_article=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="btn btn-warning">
                        Modifier
                    </a>
                    <!-- si l'utilisateur est connecté alors il peut voir le bouton ajouter un commentaire -->
                    <button  name="button_commentaire" class="btn btn-warning" id="button_commentaire<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" onclick="showDiv_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
();">
                        Ajouter un commentaire
                    </button>
                    <br />
                    <br />
                    <form action="index.php" method="post" enctype="multipart/form-data"  id="form-delete<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
                        <!--On stocke l'id article pour l'associer au commentaire -->
                        <input type="hidden" name="store_id_article" id="store_id_article" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" />      
                        <button  name="delete" class="btn btn-warning" id="button_delete<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" >
                            Supprimer l'article
                        </button>
                    </form>
                    <br />
                    <br />  
                    <div id="div_commentaire_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" style="display:none"> 
                        <!-- Formulaire de création de commentaire -->
                        <form action="index.php" method="post" enctype="multipart/form-data"  name="form-commentaire<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" id="form-commentaire<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
                            <!--On stocke l'id article pour l'associer au commentaire -->
                            <input type="hidden" name="store_id_article" id="store_id_article" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" />
                            <div class="form-group">
                              <label for="titre">Pseudo</label>
                              <input  type="texte" class="form-control" name="input_pseudo" id="input_pseudo<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" placeholder="Veuillez indiquer votre pseudo">
                            </div>
                            <div class="form-group">
                              <label for="email">Adresse email</label>
                              <input  type="email" class="form-control" name="input_email" id="input_email<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" placeholder="Veuillez saisir votre email">
                            </div>
                            <div class="form-group">
                              <label for="texte">Insérer le texte de votre commentaire</label>
                              <textarea  class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                            </div>
                            <button type="button"  name="submit" id="button_ajouter<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="btn btn-primary"  onclick="validateForm<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
()">Ajouter</button>
                        </form>   
                    </div>
              
         
                    <?php }?>
                    <!-- Coupe la chaîne liste_commentaire en segments avec pour critère "," -->
                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['value']->value['commentaires'];
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('liste_commentaires', explode(",",$_prefixVariable1));
?>
                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['value']->value['pseudos'];
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('liste_pseudos', explode(",",$_prefixVariable2));
?> 
                    <!-- on reprend la valeur qui contient le nombre de commentaire -->
                    <?php $_smarty_tpl->_assignInScope('nb', $_smarty_tpl->tpl_vars['value']->value['nb_commentaire']);
?>
                    
                    <?php if ($_smarty_tpl->tpl_vars['value']->value['nb_commentaire'] != 0) {?>
                    <!-- si le nombre de commentaire n'est pas nul alors on affichage
                    les commentaires -->

                    <div class="card">
                        <div class="card-header">
                          Commentaires
                        </div>
                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['nb']->value-1;
$_prefixVariable3=ob_get_clean();
$_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? $_prefixVariable3+1 - (0) : 0-($_prefixVariable3)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = 0, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration == 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration == $_smarty_tpl->tpl_vars['foo']->total;?>
                        <!-- pour chaque commentaire on affiche le commentaire
                        et le pseudo, on a mis $nb-1 car liste_commentaire et liste_pseudos
                        sont sous forme de tableau et le premier commentaire n'est pas à la 
                        première clé mais à la clé 0-->
          
                        <?php $_smarty_tpl->_assignInScope('n', $_smarty_tpl->tpl_vars['foo']->value);
?>    
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                              <p>
                                  <?php ob_start();
echo $_smarty_tpl->tpl_vars['n']->value;
$_prefixVariable4=ob_get_clean();
echo $_smarty_tpl->tpl_vars['liste_commentaires']->value[$_prefixVariable4];?>

                              </p>
                              <footer class="blockquote-footer">
                                  <?php ob_start();
echo $_smarty_tpl->tpl_vars['n']->value;
$_prefixVariable5=ob_get_clean();
echo $_smarty_tpl->tpl_vars['liste_pseudos']->value[$_prefixVariable5];?>

                              </footer>
                            </blockquote>
                          <br />
                        </div>
                        <?php }
}
?>
    
                    </div>
                    <?php }?>
                </div>
            </div> 
        </div>
        <br />
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        <!-- Passer d'une page à une autre... Pagination -->
        <br/>
        <div class="row justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($_smarty_tpl->tpl_vars['recherche']->value == '') {?>
                    <!-- si la recherche est pas vide alors on affiche la pagination -->
                      <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['nb_pages']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['nb_pages']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
                    <li class="page-item <?php if ($_smarty_tpl->tpl_vars['page_courante']->value == $_smarty_tpl->tpl_vars['i']->value) {?>active<?php }?>">
                        <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                    </li>
                    <?php }
}
?>

                    <?php } else { ?>
                    <!-- si la recherche n'est pas vide alors on affiche la pagination avec
                    la recherche en paramètre -->
                      <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['nb_pages']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['nb_pages']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
                    <li class="page-item <?php if ($_smarty_tpl->tpl_vars['page_courante']->value == $_smarty_tpl->tpl_vars['i']->value) {?>active<?php }?>">
                        <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
&recherche=<?php echo $_smarty_tpl->tpl_vars['recherche']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                    </li>
                    <?php }
}
?>
                           
                    <?php }?>
                </ul>
            </nav>
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
    

    <?php echo '<script'; ?>
>
             
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab_articles']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
        /**
         * 
         * pour chaque article, on suit les instructions
         */
        
        /* Fonction qui permet d'afficher une division qui est invisible (display:none) */
       
        function showDiv_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
() {
            /**
             * 
             * si la fonction est appellée alors on suit les instructions
             */
            
            /* On récupère la valeur de l'element div_commentaire et on le stocke dans la variable x*/
            var x = document.getElementById('div_commentaire_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
');
            if (x.style.display === "none") {
                /* si la div a pour display:none alors on change son display en block */
                x.style.display = "block";
            } else {
                /* si la div n'a pas pour display:none alors on change son display en none */
                x.style.display = "none";
            }
        };
        
        
        /* Fonction qui permet la vadation du formulaire (ajout du type submit au bouton submit) de création de commentaire */
        function validateForm<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
() {
            /**
             * 
             * si la fonction est appellée alors on suit les instructions
             */
            
            /* On récupère la valeur des elements html suivant */
            var pseudo = document.getElementById('input_pseudo<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
').value;
            var email = document.getElementById('input_email<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
').value;
       
            if (pseudo == "") {
                /* si le pseudo est vide on crée une alerte */
                alert("Le champ pseudo ne doit pas être vide.");
                
            }else{
                if (email == ""){
                    /* si l'email est vide on crée une alerte */
                    alert("Le champ email ne doit pas être vide.");
                    
                }else{
                    /* si l'email et le pseudo ne sont pas vide, on autorise 
                    * l'envoi du formulaire en modifiant le type du bouton_ajouter
                    * en submit
                    */
                    var y = document.getElementById('button_ajouter<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
');
                    y.setAttribute('type','submit');

                }
            }    

        };   
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 
   
    <?php echo '</script'; ?>
><?php }
}
