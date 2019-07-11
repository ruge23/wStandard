import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SorteoComponent } from './sorteo/sorteo.component';
import { VentaProductoComponent } from './venta-producto/venta-producto.component';
import { GraciasComponent } from './gracias/gracias.component';

const routes: Routes = [
  {
    path:'',
    component: SorteoComponent
  },
  {
    path:'a',
    component: GraciasComponent
  }
  /* {
    path: '/ventaProducto',
    component: VentaProductoComponent
  } */
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
