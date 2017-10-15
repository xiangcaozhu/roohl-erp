<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-08 15:31:11
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<form id="dialog-attribute-form">
<div class="buy-attribute">
	<?php
if ( $buy_attribute_list )
{
foreach ( $buy_attribute_list as $attribute )
{
?>
	<?php
if ( !$attribute['hidden'] )
{
?>
	<div class="buy-attribute-list clearfix" id="attr-box-<?php echo $attribute['id']; ?>" type="attr-box" disable="<?php echo $attribute['disable']; ?>" atype="<?php echo $attribute['type']; ?>" <?php
if ( $attribute['disable'] )
{
?>style="display:none;"<?php
}
?>>
		<div class="left">
		<span class="view-selected-attribute" id="attr-desc" title="<?php echo $attribute['name']; ?>" ><?php echo $attribute['name']; ?></span>
		<input type="hidden" id="s_attribute" name="s_attribute" value="noselect" />
		</div>
		<div class="right">

				<input type="hidden" name="attr_store[<?php echo $attribute['id']; ?>]" append="" value="" attr_name="<?php echo $attribute['name']; ?>" attr_value_name="" attr_required="<?php echo $attribute['required']; ?>"/>
				<?php
if ( $attribute['value_list'] )
{
foreach ( $attribute['value_list'] as $value )
{
?>
				<?php
if ( !$value['hidden'] )
{
?>
				<?php
if ( $value['service'] != 1 )
{
?>
				<div class="textblock" type="attr-value" id="attr-val-<?php echo $value['id']; ?>" value_id="<?php echo $value['id']; ?>" about="<?php echo $value['about_disabled']; ?>" append="<?php echo $value['append_price']; ?>" value_name="<?php echo $value['name']; ?>"><div><?php echo $value['name']; ?></div></div>
				<?php
}
?>
				<?php
}
?>
				<?php
}
}
?>

		</div>
	</div>
	<?php
}
?>
	<?php
}
}
?>
</div>
</form>