<?php
/**
 * Specify default layout
 */


/**
 * Reset Theme LE Blocks markup into proper html5 tags.
 * By default LE used section tag, however here we want to divide our blocks into proper header, footer tags for Body level.
 *
 * @param $blocks array
 * @since 1.0.0.0
 * @return array formatted blocks
 */
function le_theme_redefine_markup($blocks)
{
		if(empty($blocks)) return $blocks;
		
		foreach($blocks as $i => $block) :
	
			switch($blocks[$i]['id']) :
		
			case "header":
				$blocks[$i]['before_block'] = '<header id="branding" class="block container %2$s" role="banner">';
				$blocks[$i]['after_block']  = '</header>';
			//$blocks[$i]['before_item'] = '';
			//$blocks[$i]['after_item'] = '';
			break;
		
			case "body":
				$blocks[$i]['before_block'] = '<div id="main_body" class="block container %2$s">';
				$blocks[$i]['after_block']  = '</div>';
				$blocks[$i]['before_item'] = '<div class="blockitem %1$s %2$s %3$s">';
				$blocks[$i]['after_item'] = '</div>';
			break;
		
			case "footer":
				$blocks[$i]['before_block'] = '<footer id="colophon" role="contentinfo" class="block container %2$s">';
				$blocks[$i]['after_block']  = '</footer>';
			break;
				
			endswitch;
	
		endforeach;

		return $blocks;
}
add_filter('le_layout_blocks', 'le_theme_redefine_markup');

/**
 * Registering new block for banners but do not show it on pages
 *
 * @since 1.0.0.0
 * @return void
 */
function le_theme_new_blocks()
{
	//Registering banner after header
	LE_Base::register_block(	
					array(
								'id' => 'banner',
								'name'=>'Banner',
								'before_block' => '<div id="banner">',
								'after_block' => "</div>\n",
								'before_item' => '<div class="blockitem %1$s %2$s %3$s">', //$block_item['id'], $id,$css_column_class, $block_item['columns'], $block['id'], $block['class']
								'after_item' => "</div>\n",		
								'priority' => 60 //Header is 50, so any number greater than 50
						)
				 );
				 
	//Remove this block from page template
	$id = $_REQUEST['id'];
	if(Query_Conditions::is_page())
	{
		LE_Base::unregister_block('banner');
	}
}
add_action('init','le_theme_new_blocks');

/**
 * Setup default layout
 *
 * @since 1.0.0.0
 * @return void
 */
function le_theme_default_layout($settings)
{
	if(empty($settings))
	{
		$settings = array();
		
		//Default Layout 
		$settings['index'] = array();
		$settings['body'] = array();
		
		//Default Layout Header
		$settings['index']['header'] = array();
		
		//In order to get block items settings esp. widgets and sidebar, you need to design you layout
		//in Layout Engine, then goto Utilities and export your data
		//Currently exported data contains all the views, blocks and block items
		//You can select single block item setting or whole object if you want
		//The following are part of settings of block items.
		
		//Try to create default body layout 
		// 1-Column :: Dynamic sidebar
		// 2-Column :: Post Loop
		// 3-Column :: Category widget
		
		//Header
		$settings['index']['header'][0] = array
		(
				'id' => 'theme_header',
				'name' => 'Random Header',
				'title' => '',
				'columns' => '3',
				'runtime_id' => 'o7r7ox',
				'args' => array()
		);	

		$settings['index']['header'][1] = array
		(
				'id' => 'theme_menu',
				'name' => 'Primary menu',
				'title' => '',
				'columns' => '3',
				'runtime_id' => 'y3cAGj',
				'args' => array()
		);		
		
		//Dynamic sidebar
		$settings['index']['body'][0] = array
		(
										        'id' => 'sidebar',
										        'name' => 'Sidebar',
										        'title' => '',
										        'columns' => '1',
										        'runtime_id' => 'AOagcP',
										        'args' => 
										        array 
												(
												          'name' => 'Left Sidebar',
												          'id' => 'left-sidebar',
												          'description' => '',
												          'class' => '',
												          'before_widget' => '',
												          'after_widget' => '',
												          'before_title' => '',
												          'after_title' => '',
										        ),
		);	

		$settings['index']['body'][1] = array
		(
											'id' => 'posts_loop',
											'name' => 'Posts loop',
											'title' => '',
											'columns' => '2',
											'runtime_id' => '8ZN2VC',
											'args' => array()
		);		
		
		//Category Widget
		/***
		$settings['index']['body'][1] = array
		(
										        'id' => 'widget',
										        'name' => 'Widget',
										        'title' => '',
										        'columns' => '2',
										        'runtime_id' => 'KIkXPC',
										        'args' => array 
												(
												          'title' => 'Categories at runtime',
												          'count' => 0,
												          'hierarchical' => 1,
												          'dropdown' => 0,
												          'widget_export_id' => 'categories-4',
												          'widget_export_base_id' => 'categories',
														  'widget_export_sidebar' => 'left-sidebar', //'wp_inactive_widgets'
										        ),
		);
		***/
		
		//Notify block items / other hooks to register these settings
		LE_Utilities::import(&$settings);
	}
	
	return $settings;
}
add_filter('le_layout_settings', 'le_theme_default_layout')

?>