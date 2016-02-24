<?php
$form = array(
    /*'kode_rekam' => array(
        'name'=>'kode_rekam',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('kode_rekam', isset($form_value['kode_rekam']) ? $form_value['kode_rekam'] : '')
    ),*/
    'anamnesa'    => array(
        'name'=>'anamnesa',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('anamnesa', isset($form_value['anamnesa']) ? $form_value['anamnesa'] : '')
    ),
	'alergi'    => array(
        'name'=>'alergi',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('alergi', isset($form_value['alergi']) ? $form_value['alergi'] : '')
    ),    
	'terapi'    => array(
        'name'=>'terapi',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('terapi', isset($form_value['terapi']) ? $form_value['terapi'] : '')
    ),    
	'pasien'    => array(
        'name'=>'pasien',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('pasien', isset($form_value['pasien']) ? $form_value['pasien'] : '')
    ),   
	'injeksi'    => array(
        'name'=>'injeksi',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('injeksi', isset($form_value['injeksi']) ? $form_value['injeksi'] : '')
    ),    
	'nebu'    => array(
        'name'=>'nebu',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('nebu', isset($form_value['nebu']) ? $form_value['nebu'] : '')
    ),    
	'guladarah'    => array(
        'name'=>'guladarah',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('guladarah', isset($form_value['guladarah']) ? $form_value['guladarah'] : '')
    ),    
	'asamurat'    => array(
        'name'=>'asamurat',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('asamurat', isset($form_value['asamurat']) ? $form_value['pasien'] : '')
    ),    
	'kolesterol'    => array(
        'name'=>'kolesterol',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('kolesterol', isset($form_value['kolesterol']) ? $form_value['kolesterol'] : '')
    ),   
	/*'nama'    => array(
        'name'=>'nama',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('nama', isset($form_value['nama']) ? $form_value['nama'] : '')
    ), */    
	'tanggal'    => array(
        'name'=>'tanggal',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('tanggal', isset($form_value['tanggal']) ? $form_value['tanggal'] : ''),
        'onclick' => "displayDatePicker('tanggal')"
    ),
    'submit'   => array(
        'name'=>'submit',
        'id'=>'submit',
        'value'=>'Simpan'
    )
);
?>

<h2><?php echo $breadcrumb ?></h2>

<!-- pesan start -->
<?php if (! empty($pesan)) : ?>
    <div class="pesan">
        <?php echo $pesan; ?>
    </div>
<?php endif ?>
<!-- pesan end -->

<!-- form start -->
<?php echo form_open($form_action); ?>
 	<p>
    <?php echo form_label('Tanggal (dd-mm-yyyy)', 'tanggal'); ?>
    <?php echo form_input($form['tanggal']); ?>
    <a href="javascript:void(0);" onclick="displayDatePicker('tanggal');"><img src="<?php echo base_url('assets/images/icon_calendar.png'); ?>" alt="calendar" border="0"></a>
	</p>
	<?php echo form_error('tanggal', '<p class="field_error">', '</p>');?>

	<!--<p>
        <?php //echo form_label('Kode Rekam', 'kode_rekam'); ?>
        <?php //echo form_input($form['kode_rekam']); ?>
	</p>
	<?php //echo form_error('kode_rekam', '<p class="field_error">', '</p>');?>
	
     <p>-->
        <?php echo form_label('Nama Dokter', 'kode_dokter'); ?>
        <?php echo form_dropdown('kode_dokter', $option_datadokter, set_value('kode_dokter', isset($form_value['kode_dokter']) ? $form_value['kode_dokter'] : '')); ?>
	</p>
	<?php echo form_error('kode_dokter', '<p class="field_error">', '</p>');?>
    
    <p>
        <?php echo form_label('Kode Pasien', 'kode_pasien'); ?>
        <?php echo form_dropdown('kode_pasien', $option_datapasien, set_value('kode_pasien', isset($form_value['kode_pasien']) ? $form_value['kode_pasien'] : '')); ?>
	</p>
	<?php echo form_error('kode_pasien', '<p class="field_error">', '</p>');?>
    
  
	<p>
        <?php echo form_label('Anamnesa', 'anamnesa'); ?>
        <?php echo form_textarea($form['anamnesa']); ?>
	</p>
	<?php echo form_error('anamnesa', '<p class="field_error">', '</p>');?>	
	
    <p>
        <?php echo form_label('Alergi', 'alergi'); ?>
        <?php echo form_input($form['alergi']); ?>
	</p>
	<?php echo form_error('alergi', '<p class="field_error">', '</p>');?>	
    <p>
        <?php echo form_label('Terapi', 'terapi'); ?>
        <?php echo form_input($form['terapi']); ?>
	</p>
	<?php echo form_error('terapi', '<p class="field_error">', '</p>');?>
   	
    <p>
        <?php //echo form_label('Pasien', 'pasien'); ?>
        <?php //echo form_input($form['pasien']); ?>
	</p>
	<?php //echo form_error('pasien', '<p class="field_error">', '</p>');?>	
	<p>
    <?php echo form_label('Pasien', 'pasien'); ?>
    <?php echo form_radio('pasien', '1', set_radio('pasien', '1',isset($form_value['pasien']) && $form_value['pasien'] == '1' ? TRUE : FALSE)); ?> ( Pasien Biasa )
    <?php echo form_radio('pasien', '1', set_radio('pasien', '1',isset($form_value['pasien']) && $form_value['pasien'] == '1' ? TRUE : FALSE)); ?> ( Pasien Libur )
    <?php echo form_radio('pasien', '1', set_radio('pasien', '1',isset($form_value['pasien']) && $form_value['pasien'] == '1' ? TRUE : FALSE)); ?> ( Pasien Panggilan )
    <?php echo form_radio('pasien', '1', set_radio('pasien', '1',isset($form_value['pasien']) && $form_value['pasien'] == '1' ? TRUE : FALSE)); ?> ( Pasien Tindakan )
</p>
<?php echo form_error('pasien', '<p class="field_error">', '</p>');?>
<p>
    <?php echo form_label('Jenis Layanan'); ?>
    <?php echo form_checkbox('injeksi', '1', set_checkbox('injeksi', '1',isset($form_value['injeksi']) && $form_value['injeksi'] == '1' ? TRUE : FALSE)); ?> ( Injeksi )
    <?php echo form_checkbox('nebu', '1', set_checkbox('nebu', '1',isset($form_value['nebu']) && $form_value['nebu'] == '1' ? TRUE : FALSE)); ?> ( Nebu )
    <?php echo form_checkbox('guladarah', '1', set_checkbox('guladarah', '1',isset($form_value['guladarah']) && $form_value['guladarah'] == '1' ? TRUE : FALSE)); ?> ( Gula Darah )
    <?php echo form_checkbox('asamurat', '1', set_checkbox('asamurat', '1',isset($form_value['asamurat']) && $form_value['asamurat'] == '1' ? TRUE : FALSE)); ?> ( Asam Urat )
     <?php echo form_checkbox('kolesterol', '1', set_checkbox('kolesterol', '1',isset($form_value['kolesterol']) && $form_value['kolesterol'] == '1' ? TRUE : FALSE)); ?> ( Kolesterol )
</p>
<?php echo form_error('injeksi', '<p class="field_error">', '</p>');?>
<?php echo form_error('nebu', '<p class="field_error">', '</p>');?>
<?php echo form_error('guladarah', '<p class="field_error">', '</p>');?>
<?php echo form_error('asamurat', '<p class="field_error">', '</p>');?>
<?php echo form_error('kolesterol', '<p class="field_error">', '</p>');?>
    	
   	<p>
		<?php echo form_submit($form['submit']); ?>
        <?php echo anchor('rekammedis','Batal', array('class' => 'cancel')) ?>
	</p>
<?php echo form_close(); ?>
<!-- form start -->

<?php

?>