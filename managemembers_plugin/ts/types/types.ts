import { AlpineComponent } from "alpinejs";

export type ManageMember = {
  addNewMember: () => void;
  currentPage: number;
  deleteMember: (url: string) => void;
  fillUpdateModalInputs: (
    suffix: string,
    id:string,
    name: string,
    lastName: string,
    email: string,
    _document: string,
    memberStatus: string
  ) => void;
  limit: number;
  offset: number;
  openAddModal: boolean;
  openUpdateModal: boolean;
  pages: number;
  showPages: number[];
  toggleAddModal: (this: AlpineComponent<ManageMember>) => void;
  toggleUpdateModal: (
    this: AlpineComponent<ManageMember>
  ) => void;
  updateMember: (this:AlpineComponent<ManageMember>,id: string) => void;
  getMembers:(this:AlpineComponent<ManageMember>)=>Promise<void>;
  renderPagination:(this:AlpineComponent<ManageMember>)=>void
  nextPage:(this:AlpineComponent<ManageMember>)=>void
  previousPage:(this:AlpineComponent<ManageMember>)=>void
  goToPage:(this:AlpineComponent<ManageMember>,page:string)=>void

};

export type Member = {
  created: string;
  document: number;
  email: string;
  id: number;
  last_name: string;
  member_status: string;
  name: string;
};

export type Members = {
  pages: number;
  members: Member[];
};

export type RequestError = {
   msg:string
}

