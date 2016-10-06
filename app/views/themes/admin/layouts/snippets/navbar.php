<div class="navbar" id="main-nav">
    <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
			<a class="brand" href="<?php echo base_url('admin/dashboard')?>"><img src="<?php echo base_url('assets/agririo/images/layout/AgriRio_logo_def.png') ?>" style="height:30px"></a>
          <div class="nav-collapse collapse navbar-inverse-collapse">
            <ul class="nav">
              <li class="<?php if($this->uri->segment(3) == 'offerte') echo 'active' ?>"><a href="admin/contenuti/offerte">Offerte</a></li>
              <li class="<?php if($this->uri->segment(2) == 'luoghi') echo 'active' ?>"><a href="admin/luoghi/inventario">Luoghi</a></li>
              <!--<li class="<?php if($this->uri->segment(3) == 'news') echo 'active' ?>"><a href="admin/contenuti/news">News</a></li>-->
            </ul>

            <ul class="nav pull-right">
              <li><a target="_blank" href="<?php echo base_url() ?>">Vai al sito</a></li>
              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Azioni <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <!--<li><a href="#">Modifica Account</a></li>
                  <li><a href="#">Aggiungi Utente</a></li>
                  <li class="divider"></li>-->
                  <li><a href="<?php echo base_url('logout')?>">Esci</a></li>
                </ul>
              </li>
            </ul>
              <!--
            <form class="navbar-search pull-right" action="" id="general-search">
              <input type="text" class="search-query span3" placeholder="Cerca tra i prodotti">
            </form>
              -->
          </div><!-- /.nav-collapse -->
        </div>
    </div>
</div>
