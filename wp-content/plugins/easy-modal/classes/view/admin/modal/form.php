<?php class EModal_View_Admin_Modal_Form extends EModal_View {
	public function output()
	{
		extract($this->values)
		?><div class="wrap">
			<h2><?php 
				esc_html_e($title );
				if(!empty($modal_new_url))
					echo ' <a href="' . esc_url( $modal_new_url ) . '" class="add-new-h2">' . __('Add New', 'easy-modal' ) . '</a>';
			?></h2>
			<h2 id="emodal-tabs" class="nav-tab-wrapper">
			<?php foreach($tabs as $tab){ ?>
				<a href="#<?php echo $tab['id']?>" id="<?php echo $tab['id']?>-tab" class="nav-tab emodal-tab"><?php echo $tab['label'];?></a>
			<?php } ?>
			</h2>
			<form id="emodal-modal-editor" method="post" action="">
				<?php do_action('emodal_form_nonce');?>
				<?php wp_nonce_field( EMCORE_NONCE, EMCORE_NONCE);?>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="post-body-content">
							<div class="tabwrapper">
							<?php foreach($tabs as $tab){ ?>
								<div id="<?php echo $tab['id']?>" class="emodal-tab-content">
									<?php do_action('emodal_admin_modal_form_tab_'.$tab['id'])?>
								</div>
							<?php } ?>
							</div>
						</div>
						<div id="postbox-container-1" class="postbox-container">
							<div class="meta-box-sortables ui-sortable" id="side-sortables">
								<div class="postbox " id="submitdiv">
									<div title="Click to toggle" class="handlediv"><br></div>
									<h3 class="hndle"><span><?php _e('Publish', 'easy-modal' );?></span></h3>
									<div class="inside">
										<div id="submitpost" class="submitbox">
											<div id="minor-publishing">
												<div id="minor-publishing-actions">
													<div id="save-action">
														<a id="save-post" href="<?php echo esc_url( emodal_admin_url() .'&action=clone&id='. get_current_modal_id() .'&'. EMCORE_NONCE .'='. wp_create_nonce(EMCORE_NONCE) )?>" class="button"><?php _e('Clone', 'easy-modal' );?></a>
														<span class="spinner"></span>
													</div>
													<!--
													<div id="preview-action">
														<a id="post-preview" href="#" class="preview button"><?php _e('Preview', 'easy-modal' );?></a>
														<input type="hidden" value="" id="wp-preview" name="wp-preview">
													</div>
												-->
													<div class="clear"></div>
												</div><!-- #minor-publishing-actions -->
											</div>
											<br/>
											<div id="major-publishing-actions" class="submitbox">
												<div id="delete-action">
													<a href="<?php echo esc_url( emodal_admin_url() .'&action=delete&id[]='. get_current_modal_id() .'&'. EMCORE_NONCE .'='. wp_create_nonce(EMCORE_NONCE) )?>" class="submitdelete deletion"><?php _e('Move to Trash', 'easy-modal' );?></a>
												</div>

												<div id="publishing-action">
													<span class="spinner"></span>
													<input type="submit" accesskey="p" value="<?php _e('Publish', 'easy-modal' );?>" class="button button-primary button-large" id="publish" name="publish">
												</div>
												<div class="clear"></div>
											</div>
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<?php do_action('emodal_admin_sidebar');?>
							</div>
						</div>
					</div>
					<br class="clear"/>
				</div>
			</form>
		</div><?php
	}
}