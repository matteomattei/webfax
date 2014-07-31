<?php if(isset($_POST['sendfax']))
{ 
	echo '<h3>'.$result.'</h3>';
}
else
{
	echo form_open_multipart('send/sendfax'); 
?>
<div><input type="hidden" name="maxfilesize" value="<?php echo MAXSIZE; ?>" /></div>
<table class="showtable">
  <caption>Invia PDF via FAX</caption>
  <tr>
    <td>File</td><td><?php echo form_upload('filefax[]'); ?></td>
  </tr>
  <tr>
    <td>Numero</td><td class="leftalign"><?php echo form_dropdown('faxnumber',$contacts,'-1'); ?></td>
  </tr>
  <tr>
    <td>Notifica e-mail<br />(opzionale)</td><td class="leftalign"><?php echo form_input(array('name'=>'email','style'=>'width:100%')); ?></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center"><input type="button" name="adddocument" id="adddocument" value="Aggiungi Documento" />
    <input type="submit" name="sendfax" id="sendfax" value="Invia Fax" /></td>
  </tr>
</table>
<?php echo form_close(); } ?>
<div class="instruction">
Inviare unicamente file PDF non più grandi di <?php echo (int)(MAXSIZE/(1024*1024)); ?>Mb.
</div>