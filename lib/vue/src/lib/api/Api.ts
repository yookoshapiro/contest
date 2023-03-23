import { AxiosStatic, default as axios } from 'axios';
import Teams from './Routes/Teams';
import Stations from './Routes/Stations';

class Api
{

    protected url: string = 'http://localhost/api/';

    protected handler: AxiosStatic = axios;

    public teams: Teams = new Teams(this.url, this.handler);
    public stations: Teams = new Stations(this.url, this.handler);

}

export default new Api;