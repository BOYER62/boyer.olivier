        
        <div class="col-lg-8">
       	<!-- notifications -->
          	
       	<!-- contenu -->
          
	{foreach $tab_articles  as $value}		
        <h2>{$value.titre}</h2>
			
	<img src="img/{$value.id}.jpg" width="200px" alt="photo"/>
	<p style="text-align: justify;">{$value.texte}</p>
	<p><em><u>Publié le : {$value.date_fr}</u></em></p>
        
        
        <form action="article.php?modifier={$value.id}" method="post">
            <input type="submit" value="Modifier" />
        </form>
        
        {/foreach}
        
                <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li>
                        <a href="Index.php?numPage=1" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    {for $i=1 to $nbrePages}
                        
                        <li><a href="Index.php?numPage={$i}">{$i}</a></li>
                    {/for}
                    <li>
                        <a href="Index.php?numPage={$nbrePages}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>