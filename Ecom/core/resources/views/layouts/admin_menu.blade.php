<div class="menu">
  <ul class="list">
  	
  	<li {{ Request::is('admin-panel/home') ? 'class=active' : '' }}>
      <a href="{{ url('admin-panel/home') }}">
        <i class="material-icons">home</i>
        <span>Home</span>
      </a>
    </li>

    <li {{ (Request::is('admin-panel/unit') || Request::is('admin-panel/unit/*')) ? 'class=active' : '' }}>
      <a href="{{ route('unit.index') }}">
        <i class="material-icons">location_city</i>
        <span>Units</span>
      </a>
    </li>

    <li {{ (Request::is('admin-panel/brands') || Request::is('admin-panel/brands/*')) ? 'class=active' : '' }}>
      <a href="{{ route('brands.index') }}">
        <i class="material-icons">location_city</i>
        <span>Brands</span>
      </a>
    </li>

    <li {{ ( 
         Request::is('admin-panel/category') || Request::is('admin-panel/category/*') ||
         Request::is('admin-panel/category_sub') || Request::is('admin-panel/category_sub/*') ||
         Request::is('admin-panel/category_child') || Request::is('admin-panel/category_child/*') 
      ) ? 'class=active' : '' }}>
      <a href="javascript:void(0);" class="menu-toggle active">
        <i class="material-icons">trending_down</i>
        <span>Categories</span>
      </a>
      <ul class="ml-menu">
         <li {{ (Request::is('admin-panel/category') || Request::is('admin-panel/category/*')) ? 'class=active' : '' }}>
          <a href="{{ route('category.index') }}">
            <span>Category</span>
          </a>
        </li>

        <li {{ (Request::is('admin-panel/category_sub') || Request::is('admin-panel/category_sub/*')) ? 'class=active' : '' }}>
          <a href="{{ route('category_sub.index') }}">
            <span>Sub Category</span>
          </a>
        </li>

         <li {{ (Request::is('admin-panel/category_child') || Request::is('admin-panel/category_child/*')) ? 'class=active' : '' }}>
          <a href="{{ route('category_child.index') }}">
            <span>Child Category</span>
          </a>
        </li>
      </ul>
    </li>


    <li {{ (Request::is('admin-panel/product') || Request::is('admin-panel/product/*')) ? 'class=active' : '' }}>
      <a href="{{ route('product.index') }}">
        <i class="material-icons">location_city</i>
        <span>Products</span>
      </a>
    </li>

    <li class="active"></li>

  </ul>
</div>