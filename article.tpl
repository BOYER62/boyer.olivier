<div class="col-lg-8">
    		<!-- notifications -->
		
		
		
		<!-- contenu -->
    {if isset($modifier)}
        
        <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
	    <input type="hidden" name="id" value="{$id}" />
            <div class="clearfix">
                <label for="titre">Titre</label>
                <div class="input"><input type="text" name="titre" id="titre" value="{$titre}"></div>
            </div>
		
            <div class="clearfix">
                <label for="texte">Texte</label>
                <div class="input">
                    <textarea name="texte" id="texte" rows="10" cols="50">
                        {$texte}
                    </textarea>
                </div>
            </div>
		
            <div class="clearfix">
                <label for="image">Image</label>
                <div class="input">
                    <input type="texte" name="image" id="image" value="{$id}.jpg">
                </div>
            </div>
		
            <div class="clearfix">
                <label for="publie">Publié</label>
                <div class="input">
                    <input type="checkbox" checked="checked" name="publie" id="publie" value="on">
                </div>
            </div>
        
            <div class="form_actions">
                <input type="submit" name="valider_modifier" value="MODIFIER" class="btn btn-large btn-primary">
            </div>
        </form>
    </div>
        {else}
            {if isset($smarty.session.ajout_article)}
                {* si la session est présente on affiche le message *}
                <div class="alert alert-warning" role="alert">
                    <strong>Félicitation, </strong>Votre article a bien été enregistré!
                </div>
            {/if}
                

            <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
		
                <div class="clearfix">
                    <label for="titre">Titre</label>
                    <div class="input">
                        <input type="text" name="titre" id="titre" value="">
                    </div>
                </div>
		
                <div class="clearfix">
                    <label for="texte">Texte</label>
                    <div class="input">
                        <textarea name="texte" id="texte" rows="10" cols="50">
                        
                        </textarea>
                    </div>
                </div>
		
                <div class="clearfix">
                    <label for="image">Image</label>
                    <div class="input">
                        <input type="file" name="image" id="image" value="">
                    </div>
                </div>
		
                <div class="clearfix">
                    <label for="publie">Publié</label>
                    <div class="input">
                        <input type="checkbox" name="publie" id="publie" value="on">
                    </div>
                </div>
        
                <div class="form_actions">
                    <input type="submit" name="ajouter" value="AJOUTER" class="btn btn-large btn-primary">
                </div>
            </form>
</div>
    {/if}