<h1>AlxForm</h1>

<p>Panel de administración del formulario de contacto</p>

<form method="POST" action="">
<h3>Email</h3>
<p>Ingrese el e-mail donde llegaran todas las consultas</p>

<input type="text" name="alxform_email" id="alxform_email" value="<?php echo $alxform_email ?>" />

<h3>Encabezado del formulario</h3>
<p>Titulo que mostrara encima del formulario</p>
<input type="text" name="alxform_title" id="alxform_title" value="<?php echo $alxform_title ?>" />

<h3>Texto del Boton</h3>
<p>Para poder personalizar el boton de envio del formulario, podemos agregar el texto que mas se adapte, por ejemplo: 'enviar', 'cotizar', etc.</p>
<input type="text" name="alxform_button" id="alxform_button" value="<?php echo $alxform_button ?>" />


<h3>URL</h3>
<p>Ingrese la url donde quiera que le reedirija despues de enviar la información</p>
<input type="text" name="alxform_url" id="alxform_url" value="<?php echo $alxform_url ?>" />
<br />
<br />
<button>Guardar</button>

</form>

<br />
<br />
<i>Desarrollado por @alxdevelop</i>

