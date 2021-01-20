<template>
  <div class="content-wrap">
    <h1 style="display:none;">最新まとめニュース情報</h1>
    <div class="feed-nav-wrap">
      <transition-group tag="ul" name="items" appear>
        <li v-for="cat in cats" v-bind:key="cat.id">
          <button
            class="feed-cat-btn"
            :data-catId="cat.id"
            v-on:click="catFeedSearch"
          >
            <i v-bind:class="cat.icon"></i><br />
            {{ cat.name }}
          </button>
        </li>
      </transition-group>
    </div>
    <div class="feed-wrapper">
      <!--<button v-on:click="reverseItems">並び替え</button>-->
      <loading-component :is_show="is_loading"></loading-component>
      <p id="developer-masage">
        現在当サービスは開発中（プロトタイプ）です。今年３月までの完成を目指しております。
        バグや要望などありましたら、
        私の<a href="https://twitter.com/prog_lhaplus" target="_blank">Twitter(@prog_lhaplus)</a>
        まで連絡くださいませ。
      </p>
      <transition-group class="feed-list" name="items" tag="ul">
        <li style="color: white" v-for="post in posts" v-bind:key="post.rlf_id">
          <a :href="post.url" :title="post.title" target="_blank">
            <div
              class="feed-item"
              :style="
                'background-image: url(data:' +
                post.img_type +
                ';base64,' +
                post.img +
                ')'
              "
            >
              <div class="post-meta">
                <p v-text="post.title.substr(0, 37) + (post.title.length > 37 ? '...' : '')"></p>
                <p v-text="post.site_name"></p>
              </div>
              <!--<img :src="'data:' + post.img_type + ';base64,' + post.img" />-->
            </div>
          </a>
        </li>
      </transition-group>
      <transition name="items" appear>
        <button class="load-more-btn" v-if="is_show_btn" v-on:click="loadMorePage" :data-catId="current_cat">もっと見る</button>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    //console.log("Component mounted.");
  },
  data() {
    return {
      posts: [],
      cats: [
        { id: 0, name: "ホーム", icon: "fas fa-home" },
        { id: 1, name: "ニュース", icon: "fas fa-newspaper" },
        { id: 3, name: "アニメ", icon: "fas fa-film" },
        { id: 2, name: "ゲーム", icon: "fas fa-gamepad" },
        { id: 4, name: "趣味", icon: "fas fa-pencil-ruler" },
        { id: 5, name: "芸能", icon: "fas fa-tv" },
        { id: 6, name: "スポーツ", icon: "fas fa-running" },
        { id: 7, name: "生活", icon: "fas fa-procedures" },
        { id: 8, name: "海外", icon: "fas fa-globe-asia" },
        { id: 9, name: "テック", icon: "fas fa-microchip" },
      ],
      is_show_btn: false,
      current_page: 0,
      last_page: 0,
      current_cat: 0,
      is_loading: false
    };
  },
  created() {
    this.firstFeedLoad();
  },
  methods: {
    // 配列の要素順番を逆順にする
    reverseItems() {
      this.posts.reverse().sort();
      return;
    },
    async firstFeedLoad() {
      this.is_loading = true;
      await axios.get("/api/posts")
        .then((response) => {
          this.posts = response.data.posts.data;
          this.showMorePageBtn(
            response.data.posts.current_page,
            response.data.posts.last_page
          );
        }).catch((error) => console.log(error));
      this.is_loading = false;
    },
    async catFeedSearch(e) {
      this.is_loading = true;
      this.current_cat = e.currentTarget.getAttribute("data-catId");
      if ( this.current_cat != 0 ) {
        await axios.get("/api/posts/" + this.current_cat)
          .then((response) => {
            this.posts = response.data.posts.data;
            this.showMorePageBtn(
              response.data.posts.current_page,
              response.data.posts.last_page
            );
          }).catch((error) => console.log(error));
      }else this.firstFeedLoad();
      this.is_loading = false;
    },
    showMorePageBtn( ct_pg, lt_pg ) {
      this.current_page = ct_pg;
      this.last_page = lt_pg;
      this.is_show_btn = ct_pg != lt_pg ? true : false;
    },
    async loadMorePage( e ) {
      this.is_loading = true;
      let url;
      if ( this.current_cat == 0 ) {
        url = "/api/posts?page=" + (this.current_page + 1);
      }else {
        url = "/api/posts/" + e.currentTarget.getAttribute("data-catId") + "?page=" + (this.current_page + 1);
      }
      console.log(url);
      await axios.get( url )
        .then((response) => {
          this.posts = this.posts.concat( response.data.posts.data );
          this.showMorePageBtn(
              response.data.posts.current_page,
              response.data.posts.last_page
          );
        }).catch((error) => console.log(error));
      this.is_loading = false;
    }
  },
};
</script>