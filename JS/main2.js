
function mostrarSeccion(target) {
  const secciones = document.getElementsByTagName("section");
  for (let i = 0; i < secciones.length; i++) {
    secciones[i].style.display = "none";
  }
  const seccionMostrar = document.getElementById(target);
  if (seccionMostrar) {
    seccionMostrar.style.display = "block";
  }
}

const CargarPeliculas = async () => {
  try {
    const respuesta = await fetch(
      `https://api.themoviedb.org/3/movie/popular?api_key=ff60f9dde54fdfe327e270d3d7cc6307&language=es-MX`
    );

    if (respuesta.status === 200) {
      const datos = await respuesta.json();


      let peliculas = "";

      datos.results.forEach((pelicula) => {
        peliculas += `
        <div class="pelicula" id="${pelicula.id}">
            <a href="detalle_pelicula.html?id=${pelicula.id}"><img class="poster"  src="https://image.tmdb.org/t/p/w500/${pelicula.poster_path}"></a>
        </div>
        <h3 class="titulo"> ${pelicula.title}
        <p>⭐${pelicula.vote_average}⭐</p>
        </h3>
         `;
      });
      document.getElementById("contenedor").innerHTML = peliculas;

      // Agregar evento de clic a cada póster de película
      const posters = document.querySelectorAll('.pelicula');
      posters.forEach(poster => {
        poster.addEventListener('click', function () {
          const peliculaId = this.getAttribute('id');
          window.location.href = `detalle_pelicula.html?id=${peliculaId}`;
        });
      });
    } else if (respuesta.status == 404) {
      console.log("LA PELICULA NO EXISTE EN LA BASE DE DATOS");
    }
  } catch (error) {
    console.log(error);
  }

};

CargarPeliculas();



