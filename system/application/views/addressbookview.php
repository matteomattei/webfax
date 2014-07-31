<?php echo form_open('addressbook/update'); ?>
<table class="showtable">
  <caption>
    Rubrica
  </caption>
  <thead>
    <tr>
      <th>Intestazione</th><th>Numero</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="text" name="name[]" value="NUOVO CONTATTO" class="newaccount" onclick="this.value=''" onfocus="this.value=''" /></td>
      <td><input type="text" name="number[]" value="NUMERO" size="11" class="newaccount" onclick="this.value=''" onfocus="this.value=''" /></td>
    </tr>
<?php
$i=0;
foreach($account as $number=>$name)
{
  if(($i >= $thispage) && ($i < ($thispage + $per_page)))
  {
    print "<tr>\n";
    print "  <td><input type=\"text\" name=\"name[]\" value=\"".$name."\" /></td>";
    print "  <td><input type=\"text\" name=\"number[]\" value=\"".$number."\" size=\"11\"/></td>";
    print "</tr>\n";
  }
  $i++;
}
?>
    <tr>
      <td colspan="2" class="centeralign"><input type="submit" name="update" id="update" value="Aggiorna" /></td>
    </tr>
  </tbody>
</table>
<?php
echo '<div>';
$i=0;
foreach($account as $number=>$name)
{
  if($i < $thispage || ($i >= ($thispage+$per_page)))
  {
    print "  <input type=\"hidden\" name=\"name[]\" value=\"".$name."\" />";
    print "  <input type=\"hidden\" name=\"number[]\" value=\"".$number."\" size=\"11\"/>\n";
  }
  $i++;
}
echo '</div>';
echo $this->pagination->create_links(); 
echo form_close();
?>
