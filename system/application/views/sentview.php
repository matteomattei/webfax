<table class="showtable">
  <caption>
    Fax Inviati
  </caption>
  <thead>
    <tr>
      <th>File</th><th>Data</th><th>Dimensione</th><th>Scarica PDF</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($sent as $key=>$value)
{
  print "<tr>\n";
  print "  <td>".anchor('sent/show/'.$value['filename'].'.pdf',$value['filename'],array('title'=>'Visualizza Fax'))."</td>";
  print "  <td>".$value['date']."</td><td>".$value['size']." KB</td>";
  print "  <td>".anchor('sent/download/'.$value['filename'].'.pdf','<img src="'.base_url().'images/pdf.gif" alt="scarica fax in formato pdf" title="Scarica PDF" />',array('title'=>'Scarica Fax'))."</td>\n";
  print "</tr>\n";
}
?>
  </tbody>
</table>
<?php echo $this->pagination->create_links(); ?>