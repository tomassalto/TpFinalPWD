let carritoCompras = [];
$(document).on("click", "#logo_carrito", function () {
  let totalCompra = document.getElementById("total-Compra");
  let tabla = document.getElementById("lista__carrito");
  let sumaTot = 0;

  for (i = 1; i < tabla.rows.length; i++) {
    sumaTot += parseInt(
      tabla.rows[i].cells[2].innerHTML * tabla.rows[i].cells[3].innerHTML
    );
  }

  totalCompra.innerHTML = "Precio Total: $ " + sumaTot;
});

function verDetalle(datos) {
  let imagenInfo,
    nombreInfo,
    precioInfo,
    cantidadInfo,
    cantidadInput,
    idProductoInput;

  imagenInfo = document.getElementById("foto__detalle");
  nombreInfo = document.getElementById("nombre__detalle");
  precioInfo = document.getElementById("precio__detalle");
  cantidadInfo = document.getElementById("cantidad_detalle");
  cantidadInput = document.getElementById("ciCantidad");
  idProductoInput = document.getElementById("idProducto");

  console.log(
    "Precio:",
    datos.querySelector(".precio__producto").getAttribute("data-precio")
  );
  console.log("Cantidad:", datos.querySelector(".stock").textContent);

  imagenInfo.src = datos.querySelector(".foto__producto").src;
  nombreInfo.innerHTML = datos.querySelector(".nombre__producto").textContent;
  precioInfo.innerHTML =
    "Precio: $" +
    datos.querySelector(".precio__producto").getAttribute("data-precio");

  cantidadInfo.innerHTML =
    "Cantidad de Stock: " + datos.querySelector(".stock").textContent;
  cantidadInput.setAttribute("max", datos.querySelector(".stock").textContent);
  idProductoInput.value = datos.querySelector(
    ".idProducto_Producto"
  ).textContent;
}

function redireccionarPaginaInicio() {
  location.href = "index.php";
}

function confirmarCompra() {
  let tabla = document.getElementById("lista__carrito");
  if (tabla.rows.length > 1) {
    if (localStorage.getItem("inicio") == "si") {
      Swal.fire({
        icon: "success",
        title: "Su compra fue confirmada correctamente!",
        showConfirmButton: false,
        timer: 1500,
      });
      setTimeout("redireccionarPaginaInicio()", 1450);
    } else {
      Swal.fire({
        title: "No tienes cuenta!",
        text: "Desea crear una?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
      }).then((result) => {
        if (result.isConfirmed) {
          location.href = "registrarse.php";
        }
      });
    }
  } else {
    Swal.fire({
      icon: "error",
      title: "No hay elementos en el carrito!",
      showConfirmButton: false,
      timer: 1500,
    });
  }
}
