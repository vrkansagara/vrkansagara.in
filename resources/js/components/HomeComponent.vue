<template>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <img
          class="bd-placeholder-img card-img-top"
          src="/assets/images/vrkansagara.jpeg"
          alt="Vallabh Kansagara (VRKANSAGARA)"
        >
      </div>
      <div class="col-md-9">
        <h1 class="display-3 font-q">नमस्ते, World!</h1>
        <p>My name is Vallabh Kansagara (VRKANSAGARA). I am</p>
        <ul>
          <li>A day by Software Engineering.</li>
          <li>An Open Source Contributor.</li>
          <li>Also I do tweet known as <a class="text-decoration-none" href="https://twitter.com/vrkansagara">@vrkansagara</a>
          </li>
          <li>Open source contributor at
            <a class="text-decoration-none" href="https://github.com/vrkansagara">@GitHub</a> with various projects.
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'HomeComponent',
  mounted() {
    console.log('Component mounted.');
  },
};
</script>
