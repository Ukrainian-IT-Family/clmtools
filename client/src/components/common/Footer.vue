<template>
  <div>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-6 col-md-3">
            <ul class="list-unstyled text-small">
              <li v-bind:key="link.title" v-for="link in linksLeft">
                <RouterLink class="text-muted" :to="{ name: link.route }">{{
                  link.title
                }}</RouterLink>
              </li>
            </ul>
          </div>
          <div class="col-6 col-md-3">
            <ul class="list-unstyled text-small">
              <li v-bind:key="link.title" v-for="link in linksRight">
                <RouterLink class="text-muted" :to="{ name: link.route }">{{
                  link.title
                }}</RouterLink>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
<script>
export default {
  name: 'Footer',
  data() {
    return {
      linksLeft: [
        {
          title: this.$t("index.news") + 1,
          route: 'Tasks'
        },
        {
          title: this.$t("index.news") + 2,
          route: 'Tasks'
        }
      ],
      linksRight: [
        {
          title: this.$t("index.news") + 3,
          route: 'Tasks'
        },
        {
          title: this.$t("index.news") + 4,
          route: 'Tasks'
        }
      ]
    };
  }
};
</script>
