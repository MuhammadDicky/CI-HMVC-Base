<div class="container">
	<h1>Build theme layout!</h1>

	<div class="body">
        <!-- $view from $this->data['view'] passing trough $this->template->build() -->
        <p>This from view: '<?= $view ?>'</p>
        
        <!-- Include partial from $this->template->set_partial('optional') -->
        <?= @$template['partials']['optional']; ?>

        <p>Open: <a href="<?= site_url('home') ?>">Home</a> <a href="<?= site_url('about') ?>">About</a></p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>