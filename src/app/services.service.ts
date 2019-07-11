import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Http, Headers, RequestOptions } from '@angular/http'

@Injectable({
  providedIn: 'root'
})
export class ServicesService {
  urlReference:any;

  constructor(private  httpClient:HttpClient,private httpPost: Http) { 
    this.httpClient.get('assets/data/referencias.json').subscribe(url=>{
      this.urlReference = url['url'];
      console.log('reference', this.urlReference);
    })
  }

  sendSorteoData(data): Observable<any> {
    console.log('llego a la API', data);
    var headers = new Headers();
    headers.append('Access-Control-Allow-Origin', '*');
    headers.append('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT');
    headers.append('Accept', 'application/json');
    headers.append('content-type', 'application/json');
    const requestOptions = new RequestOptions({ headers: headers });


    var body = JSON.stringify({ nombreYapellido: data.nomApe, mail: data.email, ciudad: data.ciudad, provincia: data.provincia, moto: data.moto, productoMP: data.productoMP });
    console.log(body);
    return this.httpPost.post(this.urlReference+"guardarencuesta.php", body, { headers: headers, withCredentials: true });
  }
}
