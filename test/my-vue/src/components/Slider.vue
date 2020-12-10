<template>
  <div class="card-carousel-wrapper">
    <div class="card-carousel--nav__left" @click="moveCarousel(-1)" :disabled="atHeadOfList"></div>
    <div class="card-carousel">
      <div class="card-carousel--overflow-container">
        <div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
          <div class="card-carousel--card" v-for="item in items" :key="item.tag"><img src="../assets/images/one.png">
            <div class="card-carousel--card--footer">
              <p>{{ item.name }}</p>
              <p>{{ item.tag }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-carousel--nav__right" @click="moveCarousel(1)" :disabled="atEndOfList"></div>
  </div>
   
</template>
<script>
export default {
  name: 'Slider',
  data() {
    return {
      currentOffset: 0,
      windowSize: 3,
      paginationFactor: 220,
      items: [
        {name: 'Tycoon Thai', tag: "Thai"},
        {name: 'Ippudo', tag: "Japanese"},
        {name: 'Milano', tag: "Pizza"},
        {name: 'Tsing Tao', tag: "Chinese"},
        {name: 'Frances', tag: "French"},
        {name: 'Burma Superstar', tag: "Burmese"},
        {name: 'Salt and Straw', tag: "Ice cream"},
      ]
    }
  },
  computed: {
    atEndOfList() {
      return this.currentOffset <= (this.paginationFactor * -1) * (this.items.length - this.windowSize);
    },
    atHeadOfList() {
      return this.currentOffset === 0;
    },
  },
  methods: {
    moveCarousel(direction) {
      // Find a more elegant way to express the :style. consider using props to make it truly generic
      if (direction === 1 && !this.atEndOfList) {
        this.currentOffset -= this.paginationFactor;
      } else if (direction === -1 && !this.atHeadOfList) {
        this.currentOffset += this.paginationFactor;
      }
    },
  }

}

</script>
 
<style scoped>
.lateral-sliding {
  display: flex;
  overflow-y: hidden;
  overflow-x: scroll;
}
.lateral-sliding-item {
  display: flex;
  margin-right: 8px;
  background-color: yellow;
}
.each-img {
  width: 150px;
  height: 88px;
}
 
</style>