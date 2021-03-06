import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { VehicleListComponent } from './list/vehicle-list.component';
import { VehicleListModule } from './list/vehicle-list.module';

const ROUTES: Routes = [
  {path: '', component: VehicleListComponent},
  {path: 'type', loadChildren: './type/vehicle-type.module#VehicleTypeModule'},
  {path: 'brand', loadChildren: './brand/vehicle-brand.module#VehicleBrandModule'},
  {path: 'create', loadChildren: './create-update/vehicle-create-update.module#VehicleCreateUpdateModule'},
  {path: ':id', loadChildren: './create-update/vehicle-create-update.module#VehicleCreateUpdateModule'},
];

@NgModule({
  declarations: [],
  imports: [
    RouterModule.forChild(ROUTES),
    VehicleListModule,
  ],
  exports: [
    RouterModule,
  ],
})
export class VehicleModule {}
