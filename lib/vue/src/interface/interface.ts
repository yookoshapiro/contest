export interface User {
    id: string;
    name: string;
    is_active: boolean;
    created_at?: Date;
    updated_at?: Date;
    stations?: Array<Station>;
}

export interface Team {
    id: string;
    name: string;
    results?: Array<Result>;
    created_at?: Date;
    updated_at?: Date;
}

export interface Station {
    id: string;
    name: string;
    type: bigint;
    created_at?: Date;
    updated_at?: Date;
    users?: Array<User>;
    results?: Array<Result>
}

export interface Result {
    id: string;
    station_id: string;
    team_id: string;
    type: bigint;
    value: bigint;
    comment?: string
    created_at?: Date,
    updated_at?: Date,
    station?: Station;
    team?: Team;
}