@extends('layouts.app')

@section('titulo')
localizacion
@endsection
@section('contenido')
<div class="container mx-auto p-5">
        <h2 class="text-2xl font-bold text-center mb-5">Parques y Veterinarias Cercanas</h2>
        <p class="text-center text-gray-600">Descubre parques y veterinarias cerca de tu ubicación.</p>

        <!-- Mapa -->
        <div id="map" class="w-full h-96 bg-gray-200 mt-5"></div>

        <!-- Lista de Lugares -->
        <div id="places-list" class="mt-5 p-3 bg-white shadow rounded">
            <h3 class="text-lg font-bold">Lugares encontrados:</h3>
            <ul id="results"></ul>
        </div>
    </div>

    <script>
        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        // Crear el mapa
                        const map = new google.maps.Map(document.getElementById("map"), {
                            center: userLocation,
                            zoom: 15
                        });

                        // Mostrar marcador de la ubicación del usuario
                        new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: "Tu ubicación"
                        });

                        // Buscar lugares cercanos
                        searchNearbyPlaces(userLocation, map);
                    },
                    function (error) {
                        console.error("Error al obtener la ubicación:", error);
                        alert("No se pudo obtener tu ubicación. Verifica los permisos en tu navegador.");
                    },
                    { timeout: 10000 }
                );
            } else {
                alert("Geolocalización no soportada por tu navegador.");
            }
        }

        function searchNearbyPlaces(userLocation, map) {
            const service = new google.maps.places.PlacesService(map);
            service.nearbySearch({
                location: userLocation,
                radius: 2000,
                type: ["park", "veterinary_care"]
            }, function (results, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    const placesList = document.getElementById("results");
                    placesList.innerHTML = "";

                    results.forEach(place => {
                        const li = document.createElement("li");
                        li.textContent = `${place.name} - ${place.vicinity}`;
                        placesList.appendChild(li);

                        new google.maps.Marker({
                            position: place.geometry.location,
                            map: map,
                            title: place.name
                        });
                    });
                } else {
                    console.error("Error en la búsqueda de lugares:", status);
                    alert("No se encontraron lugares cercanos.");
                }
            });
        }
    </script>

    <!-- Cargar Google Maps con Places API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('AIzaSyDe9qROj9UU35RzRAGkRWMI5DolJzzfePc') }}&libraries=places&callback=initMap"></script>
@endsection

