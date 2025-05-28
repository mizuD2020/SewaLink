document.addEventListener("DOMContentLoaded", () => {
    // Toggle Worker Service Field
    const userRadio = document.getElementById("userRadio");
    const workerRadio = document.getElementById("workerRadio");
    const serviceField = document.getElementById("serviceField");
  
    const toggleFields = () => {
      if (workerRadio.checked) {
        serviceField.style.display = "block";
      } else {
        serviceField.style.display = "none";
      }
    };
  
    if (userRadio && workerRadio) {
      userRadio.addEventListener("change", toggleFields);
      workerRadio.addEventListener("change", toggleFields);
      toggleFields(); // Call on load
    }
  
    // Map Initialization
    const mapContainer = document.getElementById("map");
    if (mapContainer && typeof L !== "undefined") {
      const map = L.map("map").setView([27.7172, 85.3240], 13);
  
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap contributors",
      }).addTo(map);
  
      let marker;
      map.on("click", function (e) {
        const lat = e.latlng.lat.toFixed(8);
        const lng = e.latlng.lng.toFixed(8);
  
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
  
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng])
          .addTo(map)
          .bindPopup(`Lat: ${lat}<br>Lng: ${lng}`)
          .openPopup();
      });
    } else {
      console.error("Map container not found or Leaflet not loaded.");
    }
  });
  