<template>
  <v-container fluid class="w-100">
      <v-alert
      border="top"
      colored-border
      type="info"
      elevation="2"
    >
    View golfers that have requested a beverage
		</v-alert>
    <v-card>
      <gmap-autocomplete @place_changed="initMarker"></gmap-autocomplete>

      <button @click="addLocationMarker">Add</button>
    </v-card>

    <GmapMap
  :center="center"
  :zoom="zoom"
  map-type-id="terrain"
  style="width: 100%; height: 400px"
>
  <GmapMarker
    :key="index"
    v-for="(m, index) in locationMarkers"
    :position="m.position"
    :clickable="true"
    :draggable="true"
    @click="center=m.position"
  />
</GmapMap>


  </v-container>
</template>

<script>

export default {
  name: "google-map",
  data() {
    return {
      center: {
        lat: 43.24908519081348,
        lng: -79.90995445791425
      },
      zoom: 16,
      locationMarkers: [],
      locPlaces: [],
      existingPlace: null
    };
  },

  mounted() {
    this.locateGeoLocation();
  },

  methods: {
    initMarker(loc) {
      this.existingPlace = loc;
    },
    addLocationMarker() {
      if (this.existingPlace) {
        const marker = {
          lat: this.existingPlace.geometry.location.lat(),
          lng: this.existingPlace.geometry.location.lng()
        };
        this.locationMarkers.push({ position: marker });
        this.locPlaces.push(this.existingPlace);
        this.center = marker;
        this.existingPlace = null;
      }
    },
    locateGeoLocation: function() {
      navigator.geolocation.getCurrentPosition(res => {
        this.center = {
          lat: res.coords.latitude,
          lng: res.coords.longitude
        };
      });
    }
  }
};
</script>
