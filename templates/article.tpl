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
                <h1 class="mt-5">{if $action=="modifier"}
                Modifier un article
                {else}
                Ajouter un article
                {/if}
                </h1>
                <br/>
                <!-- On récupère une notification s'il elle n'est pas vide -->
                {if $notification != ""}
                <!-- On définit la couleur de la notification -->
                <div class="alert {$notification_result} alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- On définit le texte de la notification -->
                    {$notification}              
                </div>
                {/if}
          
                <form action="article.php" method="post" enctype="multipart/form-data" id="form-article">

                    <!--On stocke l'id article récupéré par l'article à modifier  -->
                    <input type="hidden" name="store_id_article" id="store_id_article" value="{$id_article}" />

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <!-- On place les valeurs dans les champs (titre ect...) par défaut elles sont vides (voir article.php), elles ne sont pas vides lorsque l'on
                        fait une modification d'article -->
                        <input  type="texte" class="form-control" name="titre" id="titre" value="{$titre}" placeholder="Veuillez choisir un titre" required>
                    </div>
                    <div class="form-group">
                        <label for="texte">Insérer le texte de votre article</label>
                        <textarea  class="form-control" id="texte" name="texte" rows="3" required>{$texte}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Insérer une image</label>
                        {if $action == "modifier" && $id_article != ""}
                        <!-- si l'on modifie un article alors on affiche l'image de l'article -->
                        <img  src="img\{$id_article}.jpg?{$time}" style="width: 20rem;"> 
                        <input type="file" name="image" class="form-control-file" id="image">
                        {else}
                        <!-- sinon on affiche juste l'input pour upload un fichier -->
                        <input type="file" name="image" class="form-control-file" id="image" required>          
                        {/if}
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label" for="publie">
                            {if $action=="modifier" AND $publie==1}
                            <!-- si l'on modifie un article alors par défaut on coche la case publie -->
                            <input class="form-check-input" id="publie" value=1 name="publie" checked type="checkbox"> Publier?
                            {else}
                            <!-- sinon ne coche pas la case -->
                            <input class="form-check-input" id="publie" value=1 name="publie" type="checkbox"> Publier?	
                            {/if}	
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="submit" value="{$action}" class="btn btn-primary">
                        {if $action == "modifier"}
                        <!-- si l'on modifie un article alors on affiche Modifier sur le bouton submit -->
                        Modifier
                        {else}
                        <!-- sinon on affiche Ajouter sur le bouton submit -->
                        Ajouter
                        {/if}
                    </button>
                </form>
            </div>
        </div>
    </div>
                
                
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/dist/jquery.validate.min.js"></script>
    <script src="js/dist/localization/messages_fr.min.js"></script>   
        
    

  