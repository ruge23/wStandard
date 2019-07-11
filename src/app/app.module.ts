import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { FormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SorteoComponent } from './sorteo/sorteo.component';
import { VentaProductoComponent } from './venta-producto/venta-producto.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { NgbdModalBasic } from './modal/modal-basic';
import { HttpClientModule } from  '@angular/common/http';
import { GraciasComponent } from './gracias/gracias.component';

@NgModule({
  declarations: [
    AppComponent,
    SorteoComponent,
    VentaProductoComponent,
    NgbdModalBasic,
    GraciasComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    AppRoutingModule,
    FormsModule,
    NgbModule.forRoot(),
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
