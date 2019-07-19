<li>
    <a href="">
        <?= $category['name'] ?>
        <!-- if has childs -->
        <?php if(isset($category['childs'])):?>
            <span class="badge pull-right">
                <i class="fa fa-plus"></i>
            </span>
        <?php endif; ?>
        <?php if(isset($category['childs'])):?>
             <ul>
                 <?= $this->getMenuHtml($category['childs']) ?>
             </ul>
        <?php endif; ?>
    </a>
</li>

