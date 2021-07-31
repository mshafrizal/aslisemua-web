<template>
  <div class="zoom-on-hover" v-bind:class="{zoomed}" @touchstart="touchZoom"
    @mousemove="move" @mouseenter="zoom" @mouseleave="unZoom"
  >
    <img class="normal" ref="normal" :src="imgNormal"/>
    <img class="zoom" ref="zoom" :src="imgZoom || imgNormal"/>
  </div>
</template>

<script>
export default {
  name: "ZoomImage",
  props: ["imgNormal", "imgZoom", "scale", "disabled"],
  data: function() {
    return {
      scaleFactor: 1,
      resizeCheckInterval: null,
      zoomed: false
    }
  },
  methods: {
    touchZoom: function(event) {
      if (this.disabled) return
      this.move(event)
      this.zoomed = !this.zoomed
    },
    zoom: function() {
      if (!this.disabled) this.zoomed = true
    },
    unZoom: function() {
      if (!this.disabled) this.zoomed = false
    },
    pageOffset: function (el) {
      var rect = el.getBoundingClientRect(),
        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      return {
        y: rect.top + scrollTop,
        x: rect.left + scrollLeft
      }
    },
    move: function(event) {
      if (this.disabled || !this.zoomed) return
      let offset = this.pageOffset(this.$el)
      let zoom = this.$refs.zoom
      let normal = this.$refs.normal
      let relativeX = event.clientX - offset.x + window.pageXOffset
      let relativeY = event.clientY - offset.y + window.pageYOffset
      let normalFactorX = relativeX / normal.offsetWidth
      let normalFactorY = relativeY / normal.offsetHeight
      let x = normalFactorX * (zoom.offsetWidth * this.scaleFactor - normal.offsetWidth)
      let y = normalFactorY * (zoom.offsetHeight * this.scaleFactor - normal.offsetHeight)
      zoom.style.left = -x + "px"
      zoom.style.top = -y + "px"
    },
    initEventLoaded: function() {
      // emit the "loaded" event if all images have been loaded
      let promises = [this.$refs.zoom, this.$refs.normal].map(function(image) {
        return new Promise(function(resolve, reject) {
          image.addEventListener("load", resolve)
          image.addEventListener("error", reject)
        })
      })
      let component = this
      Promise.all(promises).then(function() {
        component.$emit("loaded")
      })
    },
    initEventResized: function() {
      let normal = this.$refs.normal
      let previousWidth = normal.offsetWidth
      let previousHeight = normal.offsetHeight
      let component = this
      this.resizeCheckInterval = setInterval(function() {
        if ((previousWidth !== normal.offsetWidth) || (previousHeight !== normal.offsetHeight)) {
          previousWidth = normal.offsetWidth
          previousHeight = normal.offsetHeight
          component.$emit("resized", {
            width: normal.width,
            height: normal.height,
            fullWidth: normal.naturalWidth,
            fullHeight: normal.naturalHeight
          })
        }
      }, 1000)
    }
  },
  mounted: function() {
    if (this.$props.scale) {
      this.scaleFactor = parseInt(this.$props.scale)
      this.$refs.zoom.style.transform = "scale(" + this.scaleFactor + ")"
    }
    this.initEventLoaded()
    this.initEventResized()
  },
  updated: function() {
    this.initEventLoaded()
  },
  beforeDestroy: function() {
    this.resizeCheckInterval && clearInterval(this.resizeCheckInterval)
  }
}
</script>

<style scoped>
  .zoom-on-hover {
    position: relative;
    overflow: hidden;
  }
  .zoom-on-hover .normal {
    width: 100%;
  }
  .zoom-on-hover .zoom {
    position: absolute;
    opacity: 0;
    transform-origin: top left;
  }
  .zoom-on-hover.zoomed .zoom {
    opacity: 1;
  }
  .zoom-on-hover.zoomed .normal {
    opacity: 0;
  }
</style>
