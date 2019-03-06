$("#frmAcceso").on('submit', function(e)
{
    e.preventDefault();
    username=$('#username').val();
    password=$('#password').val();

    $.post("../ajax/usuario.php?op=verificar",
        {"username":username, "password":password}
        ,function(data)
    {     
        if(data!="null")
        {
            data = JSON.parse(data);
            var id_perfil = data.id_perfil;
            //alert($_SESSION['perfil']);
            $(location).attr("href","ccf.php");
 
        }
        else
        {
            alertify.error("Error de inicio de sesión, verifique usuario y contraseña.");
        }
    });
})