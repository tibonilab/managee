<ul class="nav nav-pills nav-stacked">
	

    <li class="nav-header">Contenuti</li>
	<!--<li class="<?php if($this->uri->segment(3) == 'menu') echo 'active' ?>"><a href="admin/contenuti/menu"><i class="pull-right icon-chevron-right"></i> <i class="icon-th-list"></i> Menu</a></li>-->
    <li class="<?php if($this->uri->segment(3) == 'pagine') echo 'active' ?>"><a href="admin/contenuti/pagine"><i class="pull-right icon-chevron-right"></i> <i class="icon-file"></i> Pagine</a></li>
	<li class="<?php if($this->uri->segment(3) == 'offerte') echo 'active' ?>"><a href="admin/contenuti/offerte"><i class="pull-right icon-chevron-right"></i> <i class="icon-star"></i> Offerte</a></li>
    <!--
	<li class="<?php if($this->uri->segment(3) == 'team') echo 'active' ?>"><a href="admin/contenuti/team"><i class="pull-right icon-chevron-right"></i> <i class="icon-heart"></i> Team</a></li>
	<li class="<?php if($this->uri->segment(3) == 'partners') echo 'active' ?>"><a href="admin/contenuti/partners"><i class="pull-right icon-chevron-right"></i> <i class="icon-camera"></i> Partners</a></li>
    -->
    <li class="<?php if($this->uri->segment(3) == 'gallerie') echo 'active' ?>"><a href="admin/contenuti/gallerie"><i class="pull-right icon-chevron-right"></i> <i class="icon-bookmark"></i> Vetrine</a></li>
    <!--
    <li class="<?php if($this->uri->segment(3) == 'news') echo 'active' ?>"><a href="admin/contenuti/news"><i class="pull-right icon-chevron-right"></i> <i class="icon-calendar"></i> News</a></li>
    -->
	<li class="<?php if($this->uri->segment(3) == 'testi') echo 'active' ?>"><a href="admin/contenuti/testi"><i class="pull-right icon-chevron-right"></i> <i class="icon-pencil"></i> Testi</a></li>
<!--
    <li class="<?php if($this->uri->segment(2) == 'gallerie-multimediali') echo 'active' ?>"><a href="admin/gallerie-multimediali"><i class="pull-right icon-chevron-right"></i> <i class="icon-folder-open"></i> Gallerie</a></li>
-->
    <li class="nav-header">Catalogo</li>
    <li class="<?php if($this->uri->segment(3) == 'inventario') echo 'active' ?>"><a href="admin/luoghi/inventario"><i class="pull-right icon-chevron-right"></i> <i class="icon-list"></i> Luoghi</a></li>
    <!--
	<li class="<?php if($this->uri->segment(3) == 'categorie') echo 'active' ?>"><a href="admin/luoghi/categorie"><i class="pull-right icon-chevron-right"></i> <i class="icon-folder-open"></i> Categorie</a></li>
    -->
	
    
	<li class="nav-header">Multimedia</li>
    
    <li class="<?php if($this->uri->segment(3) == 'immagini') echo 'active' ?>"><a href="admin/multimedia/immagini"><i class="pull-right icon-chevron-right"></i> <i class="icon-picture"></i> Immagini</a></li>
    <!--
	<li class="<?php if($this->uri->segment(3) == 'video') echo 'active' ?>"><a href="admin/multimedia/video"><i class="pull-right icon-chevron-right"></i> <i class="icon-film"></i> Video</a></li> 
	
	<li class="<?php if($this->uri->segment(2) == 'allegati') echo 'active' ?>"><a href="admin/allegati"><i class="pull-right icon-chevron-right"></i> <i class="icon-file"></i> Allegati</a></li>
    -->
    

	
    <?php if($this->ion_auth->in_group('admin')): ?>
    <li class="nav-header">Config Catalogo</li>
    <li class="<?php if($this->uri->segment(3) == 'tipologie') echo 'active' ?>"><a href="admin/prodotti/tipologie"><i class="pull-right icon-chevron-right"></i> <i class="icon-wrench"></i> Tipologie</a></li>
    
    <li class="<?php if($this->uri->segment(3) == 'gruppi-caratteristiche') echo 'active' ?>"><a href="admin/prodotti/gruppi-caratteristiche"><i class="pull-right icon-chevron-right"></i> <i class="icon-th-large"></i> Gruppi</a></li>
	
	<li class="<?php if($this->uri->segment(3) == 'caratteristiche') echo 'active' ?>"><a href="admin/prodotti/caratteristiche"><i class="pull-right icon-chevron-right"></i> <i class="icon-flag"></i> Caratteristiche</a></li>
	
	
    <li class="<?php if($this->uri->segment(3) == 'proprieta') echo 'active' ?>"><a href="admin/prodotti/proprieta"><i class="pull-right icon-chevron-right"></i> <i class="icon-tags"></i> Proprietà</a></li>
	
	<?php /*
	<li class="<?php if($this->uri->segment(3) == 'links') echo 'active' ?>"><a href="admin/prodotti/links"><i class="pull-right icon-chevron-right"></i> <i class="icon-share"></i> Links</a></li>
	*/ ?>
	


    

<!--
    <li class="nav-header">Configurazione</li>
    <li class="<?php if($this->uri->segment(2) == 'spese-spedizione') echo 'active' ?>"><a href="admin/spese-spedizione"><i class="pull-right icon-chevron-right"></i> <i class="icon-share-alt"></i> Spedizioni</a></li>
    -->

	
	<li class="nav-header">Configurazioni</li>
<li class="<?php if($this->uri->segment(2) == 'posizione') echo 'active' ?>"><a href="admin/posizione"><i class="pull-right icon-chevron-right"></i> <i class="icon-map-marker"></i> Posizione</a></li>
    <li class="<?php if($this->uri->segment(2) == 'routes') echo 'active' ?>"><a href="admin/routes"><i class="pull-right icon-chevron-right"></i> <i class="icon-edit"></i> URLs</a></li>
	<li class="<?php if($this->uri->segment(2) == 'languages') echo 'active' ?>"><a href="admin/languages"><i class="pull-right icon-chevron-right"></i> <i class="icon-globe"></i> Lingue</a></li>
	<li class="<?php if($this->uri->segment(2) == 'configs') echo 'active' ?>"><a href="admin/configs"><i class="pull-right icon-chevron-right"></i> <i class="icon-wrench"></i> Params</a></li>
	
    
    <?php endif ?>
</ul>
