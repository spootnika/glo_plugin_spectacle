<?php
/*
	Plugin Name: Spectacle
*/

	class Spectacle_Plugin 
	{
		public function __construct()
		{
			add_action('wp_enqueue_scripts',array($this, 'wp_add_enqueue_scripts'));
			add_action('init', array($this, 'mon_custum_post_type'));
			add_shortcode('affiche_spectacle',array($this, 'display_spectacle'));
		}

		public function wp_add_enqueue_scripts()
		{
			wp_enqueue_style('style_css', plugins_url('css/style.css',__FILE__));
			wp_enqueue_script('script_js', plugins_url('js/script.js',__FILE__));
		}

		public function mon_custum_post_type()
		{
			$labels = array(
				'name' => 'Spectacles',
				'singular_name' => 'spectacle',
				'menu_name'          => 'Spectacle',
				'name_admin_bar'     => 'Spectacle',
				'add_new'            => 'Add New',
				'add_new_item'       => 'Add New Spectacle',
				'new_item'           => 'New Spectacle',
				'edit_item'          => 'Edit Spectacle',
				'view_item'          => 'View Spectacle', 
				'all_items'          => 'All Spectacles', 
				'search_items'       => 'Search Spectacles', 
				'parent_item_colon'  => 'Parent Spectacles:',				
				'not_found'          => 'No Spectacles found.',				
				'not_found_in_trash' => 'No Spectacles found in Trash.', 
				);
			$args = array(
				'labels'             => $labels,
                'description'        => 'Administration Spectacle',
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'Spectacle' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array('title', 'thumbnail','picture')

			);
			register_post_type('spectacle',$args);
		}

		public function display_spectacle($atts)
		{
			$atts = shortcode_atts(array('order'=>''),$atts);
			$args = array('post_type' => 'spectacle', 'order'=> $atts['order'],);
			$query = new WP_Query($args);
			if ($query -> have_posts()): 
				
					while($query -> have_posts()): 
						$query -> the_post();
						?>
						<h1>
						<?php       
						the_title(); // echo the field du champ pour l'image du spectacle
						?>
						</h1>
                    	<img src="<?php echo the_field('affiche'); ?>" alt="">
						<?php
						the_content();
						the_permalink();
					endwhile;
				endif;
		}	

	}

	//Instance
	new Spectacle_Plugin();
