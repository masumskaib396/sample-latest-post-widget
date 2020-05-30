<?php 
// Adds widget: srpw Latest Posts
class Srpwlatestposts_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'srpwlatestposts_widget',
			esc_html__( 'Smpale Latest Posts Widget', 'srpw-companion' )
		);
	}

	private $widget_fields = array(
		array(
			'label' => 'Number of posts',
			'id' => 'count',
			'type' => 'text',
		),
	);

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		// Output generated fields

        $latest_posts = new WP_Query([
            'posts_per_page'=>$instance['count'],
            'order'=>'desc'
        ]);

        ?>
        <div class="srpw--widget">
            <?php 
                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                }
                while($latest_posts->have_posts()){
                    $latest_posts->the_post();
            ?>

            <div class="srpw--media">
                <a href="<?php the_permalink() ?>">
                    <?php the_post_thumbnail('medium') ;?>
                </a>
                <div class="srpw--media-body">
                    <h6>
                        <a href="<?php the_permalink() ;?>"> <?php the_title(); ?> </a>
                    </h6>
                    <p><?php echo get_the_date() ;?></p>
                </div>
            </div>        


            <?php 
                }
                ?>

        </div>
        <?php
		
        echo $args['after_widget'];
        wp_reset_postdata();
	}

	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$default = '';
			if ( isset($widget_field['default']) ) {
				$default = $widget_field['default'];
			}
			$widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html__( $default, 'srpw-companion' );
			switch ( $widget_field['type'] ) {
				default:
					$output .= '<p>';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'srpw-companion' ).':</label> ';
					$output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'srpw-companion' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'srpw-companion' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
		$this->field_generator( $instance );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
}

function register_srpwlatestposts_widget() {
	register_widget( 'Srpwlatestposts_Widget' );
}
add_action( 'widgets_init', 'register_srpwlatestposts_widget' );