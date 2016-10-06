<ul class="breadcrumb">
<?php 
    for($k=2; $k<= $this->uri->total_segments(); $k++)
    {
        if(!is_numeric($this->uri->segment($k)))
            $segments[] = $this->uri->segment($k);

    }
    
    $total = count($segments) - 1;

    for($k=0; $k<= $total; $k++):?>
    <li<?php echo ($k == $total) ? ' class="active"' : '' ?>>
        <?php if($k>0): ?><span class="divider">/</span> <?php endif ?>
        
        <?php if($k == $total): ?>
            <?php echo str_replace('-', ' ', ucfirst($segments[$k])) ?>
        <?php else: ?>
            <?php 
            $link = '';
            for($i=1; $i<=($k+2); $i++)
            {
                $link .= '/'. $this->uri->segment($i);
            }
            ?>
            <a href="<?php echo base_url($link) ?>"><?php echo str_replace('-', ' ', ucfirst($segments[$k])) ?></a>
        <?php endif ?>
    </li>
<?php endfor ?>
</ul>