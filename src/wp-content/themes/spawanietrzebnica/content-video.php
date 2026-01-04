<?php $link_video = get_post_meta(get_the_ID(),'_cmb_link_video', true);?>
<div id="post-<?php the_ID(); ?>" <?php post_class("blog-post"); ?>>
								 <iframe height="430px" width="100%" src="<?php echo esc_url($link_video); ?>"></iframe>
								<div class="post-content-text">
										<ul class="blog_infos nav">
                            <li><a href="<?php the_permalink(); ?>"><i class="fa fa-calendar"></i><?php the_date(); ?></a></li>
                           <li><span><i class="fa fa-user"></i> <?php the_author(); ?> </span></li>
							<li><span><i class="fa fa-comments-o"></i> <?php comments_number( esc_html__(' 0 comment', 'welderpro'), esc_html__(' 1 comment', 'welderpro'), esc_html__('% comments', 'welderpro') ); ?></span></li>
                        </ul>
                        			<?php $title = get_the_title(); ?> 
									<h2 class="title"><a href="<?php the_permalink(); ?>"><?php if (strlen($title) == 0) esc_html_e('Untitled Posts', 'welderpro'); else echo esc_html($title); ?></a></h2>
									
									<p><?php echo esc_attr(welderpro_excerpt()); ?></p>
									<a href="<?php the_permalink(); ?>" class="btn readmore"><?php esc_html_e('Read more', 'welderpro') ?></a> 
								</div>
							</div>
