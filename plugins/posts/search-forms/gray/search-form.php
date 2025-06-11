<?php 
/**
 * Posts Locator "gray" search form template file. 
 * 
 * The information on this file will be displayed as the search forms.
 * 
 * The function pass 1 args for you to use:
 * $gmw  - the form being used ( array )
 * 
 * You could but It is not recomemnded to edit this file directly as your changes will be overridden on the next update of the plugin.
 * Instead you can copy-paste this template ( the "gray" folder contains this file and the "css" folder ) 
 * into the theme's or child theme's folder of your site and apply your changes from there. 
 * 
 * The template folder will need to be placed under:
 * your-theme's-or-child-theme's-folder/geo-my-wp/posts/search-forms/
 * 
 * Once the template folder is in the theme's folder you will be able to choose it when editing the Posts locator form.
 * It will show in the "Search results" dropdown menu as "Custom: gray".
 */
?>
<?php 
//custom locator button
if  ( !function_exists('gmw_locator_button') && $gmw['search_form']['locator_icon'] != 'within_address_field' ) {	
	function gmw_locator_button( $button, $gmw, $class ) {
		
		$lSubmit = ( isset( $gmw['search_form']['locator_submit'] ) && $gmw['search_form']['locator_submit'] == 1 ) ? 'gmw-locator-submit' : '';
		
		//remove this filter to prevent it from effecting other forms
		remove_filter( 'gmw_search_form_locator_button_img','gmw_locator_button', 10, 3 );
		
		return '<div id="'.$gmw['ID'].'" class="gmw-locator-button gmw-locate-btn '.$class.' '.$lSubmit.'">'.$gmw['labels']['search_form']['get_my_location'].'</div>';
	}
	add_filter( 'gmw_search_form_locator_button_img','gmw_locator_button', 10, 3 );
}
?>
<?php 

do_action( 'gmw_before_search_form_template', $gmw ); 

// Jean - Added Custom Search Bar
?>

<div class="gmw-form-wrapper gmw-form-wrapper<?php echo $gmw['ID']; ?> gmw-pt-form-wrapper gmw-pt-gray-form-wrapper">
	
	<form class="gmw-form gmw-form-<?php echo $gmw['ID']; ?>" name="gmw_form" action="<?php echo $gmw['search_results']['results_page']; ?>" method="get">
		<?php $years = range(2010,date("Y")); ?>
		
    	<?php do_action( 'gmw_search_form_before_post_types', $gmw ); ?>
				
		<!-- post types dropdown -->
                <div class="row">
                    <div class="col-sm-6" style="display:none;">
                        Soort telpunt:
                        <br>
                        <?php gmw_pt_form_post_types_dropdown( $gmw, false, false, 'Alles in deze gemeente', $gmw['page_load_results']['post_types'][0]);?>
                    </div>
                    <div class="col-lg-3 d-flex flex-column justify-content-end">
                        Jaar:
                        <p>
                        <select name="bokwold_metas[jaar]" style="width: auto;">
                            <option value="">Vanaf</option>
                            <?php 
                            foreach($years as $year) {
                                echo '<option value="'.$year.'" '. (isset($_GET['bokwold_metas']['jaar']) && $_GET['bokwold_metas']['jaar'] == $year ? 'selected' : '') .'>'.$year.'</option>';
                            }
                            ?>
                        </select>
                        <select name="bokwold_metas[maxjaar]" style="width: auto;">
                            <option value="">Tot</option>
                            <?php 
                            foreach($years as $year) {
                                echo '<option value="'.$year.'" '. (isset($_GET['bokwold_metas']['maxjaar']) && $_GET['bokwold_metas']['maxjaar'] == $year ? 'selected' : '') .'>'.$year.'</option>';
                            }
                            ?>
                        </select>
                            </p>
                    </div>
                    <div class="col-lg-3 d-flex flex-column justify-content-end">
                        Intensiteit gemotoriseerd vkr<br/> (werkdaggemiddelde):
                        <p>
                        <input class="numbers" name="intensiteitMin" placeholder="Min." type="text" value="<?=isset($_GET['intensiteitMin']) ? $_GET['intensiteitMin'] : ''; ?>" style="max-width:45%;" oninput="valid(this)" /> - 
                        <input class="numbers" name="intensiteitMax" placeholder="Max." type="text" value="<?=isset($_GET['intensiteitMax']) ? $_GET['intensiteitMax'] : ''; ?>" style="max-width:45%;" oninput="valid(this)" />
                        </p>
                    </div>
                    <div class="col-lg-3 d-flex flex-column justify-content-end">
                        Intensiteit langzaam vkr<br/> (werkdaggemiddelde):
                        <p>
                        <input class="numbers" name="intensiteitLgzMin" placeholder="Min." type="text" value="<?=isset($_GET['intensiteitLgzMin']) ? $_GET['intensiteitLgzMin'] : ''; ?>" style="max-width:45%;" oninput="valid(this)" /> - 
                        <input class="numbers" name="intensiteitLgzMax" placeholder="Max." type="text" value="<?=isset($_GET['intensiteitLgzMax']) ? $_GET['intensiteitLgzMax'] : ''; ?>" style="max-width:45%;" oninput="valid(this)" />
                        </p>
                    </div>
                    <div class="col-lg-3 d-flex flex-column justify-content-end">
                        Snelheid <br/>(werkdaggemiddelde):
                        <p>
                        <input class="numbers" name="intensiteitSnelheidMin" placeholder="Min." type="text" value="<?=isset($_GET['intensiteitSnelheidMin']) ? $_GET['intensiteitSnelheidMin'] : ''; ?>" style="max-width:45%;" oninput="valid(this)" /> - 
                        <input class="numbers" name="intensiteitSnelheidMax" placeholder="Max." type="text" value="<?=isset($_GET['intensiteitSnelheidMax']) ? $_GET['intensiteitSnelheidMax'] : ''; ?>" style="max-width:45%;" oninput="valid(this)" />
                        </p>
                    </div>
		</div>
		<input type="submit"  class="gmw-submit gmw-submit-8" value="Zoeken">
		
	</form>
	
</div><!--form wrapper -->	

<script> 
    $('.numbers').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
    var jaar = '<?php echo (isset($_GET['bokwold_metas']['jaar']) && !empty($_GET['bokwold_metas']['jaar']) ? $_GET['bokwold_metas']['jaar'] : '') ?>';
</script> 

<?php do_action( 'gmw_after_search_form_template', $gmw ); ?>