<template>
  <GMapMap
      :center="center"
      :zoom="6"
      :options="{
        zoomControl: true,
        fullscreenControl: true,
      }"
      style="width: 100vw; height: 800px"
  >
    <GMapCluster
      :minimumClusterSize="40"
      :zoomOnClick="true"
      :zoom-on-click="true"
      :minimum-cluster-size="40"
      >
      <GMapMarker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :title="m.title"
          :clickable="true"
          :draggable="false"
          @click="openMarker(m.id)"
        >
        <GMapInfoWindow
          :closeclick="true"
          @closeclick="openMarker(null)"
          :opened="openedMarkerID === m.id"
          >
          <div v-html="m.url" class="gmap-marker"></div>
          <div v-html="m.extra" class="gmap-marker"></div>
        </GMapInfoWindow>
      </GMapMarker>
    </GMapCluster>


  </GMapMap>
</template>

<script>

export default {
  props: ["markerlist"],
  name: 'App',
  data() {
    return {
      openedMarkerID: null,
      center: {lat: 52.49, lng: -3.2},
      markers: this.markerlist,
    }
  },
  methods: {
      openMarker(id) {
          this.openedMarkerID = id;
      },
  }
};

</script>

<style>
  body {
    margin: 0;
  }
</style>
