<template>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?=$this->url('home')?>">Vallabh Kansagara (VRKANSAGARA)</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto mb-2 mb-md-0">
          <li class="nav-item active">
            <a class="nav-link" aria-current="page" href="<?=$this->url('home')?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$this->url('blog')?>">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$this->url('projects')?>">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$this->url('resume')?>">Resume</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$this->url('contact')?>">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$this->url('about')?>">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form  method="get" action="<?=$this->url('search')?>"  class="d-flex">
          <input  name="name" value="" id="searchAnyThing" class="form-control mr-2" type="search" placeholder="Search anything..." aria-label="Search anything...">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
