import { AlpineComponent } from "alpinejs";

export type ManageMember = {
  deleteMember: (url: string) => void;
  fillUpdateModalInputs: (name:string)=>void
  openAddModal:boolean,
  openUpdateModal: boolean;
  toggleAddModal:(this:AlpineComponent<ManageMember>)=>void
  toggleUpdateModal: (this: AlpineComponent<ManageMember>,name:string) => void;
};
