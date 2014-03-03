<!-- formulario -->
<div class="wrap_alxform">
  <h3><?php echo $title ?></h3>
  <form action="" method="post" id="alxform_form">
    <label for="alxform_name">Nombre:*</label>
    <input type="text" name="alxform_name" id="alxform_name" />
    <label for="alxform_email">Email:*</label>
    <input type="text" name="alxform_email" id="alxform_email" />
    <label for="alxform_tel">Telefono (con Lada):*</label>
    <input type="text" name="alxform_tel" id="alxform_tel" />
    <label for="alxform_cd">Ciudad:*</label>
    <input type="text" name="alxform_cd" id="alxform_cd" />
    <label for="alxform_msj">Mensaje:*</label>
    <textarea name="alxform_msj" id="alxform_msj" ></textarea>
    <div id="alxform_wrap_error"></div>
    <button id="alxform_btn"><?php echo $button ?></button>
  </form>
  
</div><!-- .wrap_alxform-->
