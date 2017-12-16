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
        {if $notification != ""}
        <div class="alert {$notification_result} alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        {$notification}              
        </div>
        {/if}
        <br/>
        {foreach from=$tab_articles item=value}
        <!-- Pour chaque article, on associe ses valeurs -->
        <div class="row justify-content-center"> 
            <div class="card col-md-10">
                <img class="card-img-top" src="img/{$value.id}.jpg?{$time}"  style="width: 20rem;">
                
                <div class="card-body">
                    <h4 class="card-title">
                        {$value.titre} 
                        <br/>
                    </h4>
                            
                    <p class="card-text">
                        {$value.texte}
                    </p>
                    <button class="btn btn-primary">
                        Crée le {$value.date_fr}
                    </button>
                    {if $is_connect == "TRUE"}
                    <!-- si l'utilisateur est connecté alors il peut voir le bouton modifier l'article -->
                    <a href="article.php?action=modifier&id_article={$value.id}" class="btn btn-warning">
                        Modifier
                    </a>
                    <!-- si l'utilisateur est connecté alors il peut voir le bouton ajouter un commentaire -->
                    <button  name="button_commentaire" class="btn btn-warning" id="button_commentaire{$value.id}" onclick="showDiv_{$value.id}();">
                        Ajouter un commentaire
                    </button>
                    <br />
                    <br />
                    <form action="index.php" method="post" enctype="multipart/form-data"  id="form-delete{$value.id}">
                        <!--On stocke l'id article pour l'associer au commentaire -->
                        <input type="hidden" name="store_id_article" id="store_id_article" value="{$value.id}" />      
                        <button  name="delete" class="btn btn-warning" id="button_delete{$value.id}" >
                            Supprimer l'article
                        </button>
                    </form>
                    <br />
                    <br />  
                    <div id="div_commentaire_{$value.id}" style="display:none"> 
                        <!-- Formulaire de création de commentaire -->
                        <form action="index.php" method="post" enctype="multipart/form-data"  name="form-commentaire{$value.id}" id="form-commentaire{$value.id}">
                            <!--On stocke l'id article pour l'associer au commentaire -->
                            <input type="hidden" name="store_id_article" id="store_id_article" value="{$value.id}" />
                            <div class="form-group">
                              <label for="titre">Pseudo</label>
                              <input  type="texte" class="form-control" name="input_pseudo" id="input_pseudo{$value.id}" placeholder="Veuillez indiquer votre pseudo">
                            </div>
                            <div class="form-group">
                              <label for="email">Adresse email</label>
                              <input  type="email" class="form-control" name="input_email" id="input_email{$value.id}" placeholder="Veuillez saisir votre email">
                            </div>
                            <div class="form-group">
                              <label for="texte">Insérer le texte de votre commentaire</label>
                              <textarea  class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                            </div>
                            <button type="button"  name="submit" id="button_ajouter{$value.id}" class="btn btn-primary"  onclick="validateForm{$value.id}()">Ajouter</button>
                        </form>   
                    </div>
              
         
                    {/if}
                    <!-- Coupe la chaîne liste_commentaire en segments avec pour critère "," -->
                    {assign var="liste_commentaires" value=","|explode:{$value.commentaires}}
                    {assign var="liste_pseudos" value=","|explode:{$value.pseudos}} 
                    <!-- on reprend la valeur qui contient le nombre de commentaire -->
                    {$nb = $value.nb_commentaire}
                    
                    {if $value.nb_commentaire != 0}
                    <!-- si le nombre de commentaire n'est pas nul alors on affichage
                    les commentaires -->

                    <div class="card">
                        <div class="card-header">
                          Commentaires
                        </div>
                        {for $foo=0 to {$nb-1}}
                        <!-- pour chaque commentaire on affiche le commentaire
                        et le pseudo, on a mis $nb-1 car liste_commentaire et liste_pseudos
                        sont sous forme de tableau et le premier commentaire n'est pas à la 
                        première clé mais à la clé 0-->
          
                        {$n=$foo}    
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                              <p>
                                  {$liste_commentaires[{$n}]}
                              </p>
                              <footer class="blockquote-footer">
                                  {$liste_pseudos[{$n}]}
                              </footer>
                            </blockquote>
                          <br />
                        </div>
                        {/for}    
                    </div>
                    {/if}
                </div>
            </div> 
        </div>
        <br />
        {/foreach}
        <!-- Passer d'une page à une autre... Pagination -->
        <br/>
        <div class="row justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {if $recherche == ""}
                    <!-- si la recherche est pas vide alors on affiche la pagination -->
                      {for $i=1 to $nb_pages}
                    <li class="page-item {if $page_courante == $i}active{/if}">
                        <a class="page-link" href="?page={$i}">{$i}</a>
                    </li>
                    {/for}
                    {else}
                    <!-- si la recherche n'est pas vide alors on affiche la pagination avec
                    la recherche en paramètre -->
                      {for $i=1 to $nb_pages}
                    <li class="page-item {if $page_courante == $i}active{/if}">
                        <a class="page-link" href="?page={$i}&recherche={$recherche}">{$i}</a>
                    </li>
                    {/for}                           
                    {/if}
                </ul>
            </nav>
        </div> 
    </div>
            


    

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/dist/jquery.validate.min.js"></script>
    <script src="js/dist/localization/messages_fr.min.js"></script>  
    

    <script>
             
    {foreach from=$tab_articles item=value}
        /**
         * 
         * pour chaque article, on suit les instructions
         */
        
        /* Fonction qui permet d'afficher une division qui est invisible (display:none) */
       
        function showDiv_{$value.id}() {
            /**
             * 
             * si la fonction est appellée alors on suit les instructions
             */
            
            /* On récupère la valeur de l'element div_commentaire et on le stocke dans la variable x*/
            var x = document.getElementById('div_commentaire_{$value.id}');
            if (x.style.display === "none") {
                /* si la div a pour display:none alors on change son display en block */
                x.style.display = "block";
            } else {
                /* si la div n'a pas pour display:none alors on change son display en none */
                x.style.display = "none";
            }
        };
        
        
        /* Fonction qui permet la vadation du formulaire (ajout du type submit au bouton submit) de création de commentaire */
        function validateForm{$value.id}() {
            /**
             * 
             * si la fonction est appellée alors on suit les instructions
             */
            
            /* On récupère la valeur des elements html suivant */
            var pseudo = document.getElementById('input_pseudo{$value.id}').value;
            var email = document.getElementById('input_email{$value.id}').value;
       
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
                    var y = document.getElementById('button_ajouter{$value.id}');
                    y.setAttribute('type','submit');

                }
            }    

        };   
    {/foreach} 
   
    </script>