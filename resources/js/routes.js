import Home from './components/pages/Home.vue';
import Login from './components/pages/Login.vue';
import Register from './components/pages/Register.vue';
import RecipeList from './components/pages/RecipeList.vue';
import RecipeCreate from './components/pages/RecipeCreate.vue';
import RecipeEdit from './components/pages/RecipeEdit.vue';
import RecipeView from './components/pages/RecipeView.vue';

export default [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
  },
  {
    path: '/recipes',
    name: 'recipeList',
    component: RecipeList,
    meta: { requiresAuth: true },
  },
  {
    path: '/recipes/create',
    name: 'recipeCreate',
    component: RecipeCreate,
    meta: { requiresAuth: true },
  },
  {
    path: '/recipes/:id/edit',
    name: 'recipeEdit',
    component: RecipeEdit,
    meta: { requiresAuth: true },
  },
  {
    path: '/recipes/:id',
    name: 'recipeView',
    component: RecipeView,
    meta: { requiresAuth: true },
  },
];