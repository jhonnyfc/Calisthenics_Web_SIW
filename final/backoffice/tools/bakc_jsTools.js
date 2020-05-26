function delteData(table,camp,id) {
    $.ajax({
        type: "POST",
        url: "index.php",
        data: {accion:'tools', id:'0',tableNa:table, campo:camp, id_Data:id},
        cache: false,
        dataType: "json",
        success: function(result) {
            if (result[0] == -1){
                swal("error", result[1], "error");
            } else {
                location.reload();
            }
        },
        error: function (request, status, error) {
            swal("error", "error en el proceso"+request.responseText, "error");
        }
    });
}

function altaAdmin() {
    $.ajax({
        type: "POST",
        url: "index.php",
        data: {accion:'gestion_admin', id:'20', nombre:$("#mi_nombre").val(), ap1:$("#mi_ape1").val(), ap2:$("#mi_ape2").val(), correo:$("#mi_correo").val(), pass:$("#mi_pass").val()},
        cache: false,
        dataType: "json",
        success: function(result) {
            if (result[0] == -1){
                swal("error", result[1], "error");
            } else {
                swal("success", result[1], "success");
                var campos = ["mi_nombre","mi_ape1","mi_ape2","mi_correo","mi_pass"];
                for (i = 0; i < campos.length; i++){
                    document.getElementById(campos[i]).value = '';
                }
            }
        },
        error: function (request, status, error) {
            swal("error", "error en el proceso"+request.responseText, "error");
        }
    });
}

function subirPublicacion() {
    $.ajax({
        type: "POST",
        url: "index.php",
        data: {accion:'insertbbdd', id:'40', titulo:$("#mi_Titulo").val(), contenido:$("#mi_contenido").val(), autor:$("#mi_Autor").val()},
        cache: false,
        dataType: "json",
        success: function(result) {
            if (result[0] == -1){
                swal("error", result[1], "error");
            } else {
                swal("success", result[1], "success");
                var campos = ["mi_Titulo","mi_contenido","mi_Autor"];
                for (i = 0; i < campos.length; i++){
                    document.getElementById(campos[i]).value = '';
                }
            }
        },
        error: function (request, status, error) {
            swal("error", "error en el proceso", "error");
        }
    });
}

function subirEjercicio() {
    $.ajax({
        type: "POST",
        url: "index.php",
        data: {accion:'insertbbdd', id:'10',namEjer:$("#mi_namEjer").val(), secMusc:$("#mi_Musc").val(), ejerNiv:$("#mi_Nivel").val(), descri:$("#mi_Descripcion").val(), idFoto:$("#mi_namFoto").val()},
        cache: false,
        dataType: "json",
        success: function(result) {
            if (result[0] == -1){
                swal("error", result[1], "error");
            } else {
                swal("success", result[1], "success");
                var campos = ["mi_namEjer","mi_Musc","mi_Nivel","mi_Descripcion","mi_namFoto"];
                for (i = 0; i < campos.length; i++){
                    document.getElementById(campos[i]).value = '';
                }
            }
        },
        error: function (request, status, error) {
            swal("error", "error en el proceso"+request.responseText, "error");
        }
    });
}

function poIma(name){
    Swal.fire({
        imageUrl: name,
        width: 700,
        imageHeight: 700,
        // confirmButtonText: "Go Back", 
    });
}