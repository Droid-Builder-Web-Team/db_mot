<template>
  <GMapMap
      :center="center"
      :zoom="6"
      style="width: 100vw; height: 600px"
  >
    <GMapCluster
      :minimumClusterSize="10"
      :zoomOnClick="true"
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
          <div>Test: {{ m.title }}</div>
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
      center: {lat: 51.49, lng: -3.2},
      markers: this.markerlist,
    }
  },
  methods: {
      openMarker(id) {
          console.log(id);
          this.openedMarkerID = this.markerlist[id]['title'];
      },
  }
};

</script>

<style>
  body {
    margin: 0;
  }
</style>
