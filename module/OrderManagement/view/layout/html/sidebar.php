<aside class="main-sidebar">
  	<section class="sidebar">
  		<ul class="sidebar-menu tree" data-widget="tree">
	      	<li>
		        <a href="<?= $this->url('users', ['action' => 'list']); ?>">
		            <i class="glyphicon glyphicon-user"></i>
		            <span>Users</span>
		        </a>
	      	</li>

	      	<li>
                <a href="<?= $this->url('orderManagement', ['action' => 'index']); ?>">
                    <i class="fa fa-truck"></i>
                    <span>Orders</span>
                </a>
          	</li>
        </ul>
    </section>
</aside>

