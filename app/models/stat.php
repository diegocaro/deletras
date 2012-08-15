<?php

class Stat extends AppModel
{
    var $belongsTo = array('Track');
    //var $primaryKey = array('track_id','date');
    
    
    function TopTracks ($desde, $hasta, $n = 10)
    {
        $ret = $this->query("SELECT sum(count) AS count, Track.name, Artist.name 
                FROM stats AS Stat 
                LEFT JOIN tracks AS Track ON (Stat.track_id = Track.id) 
                LEFT JOIN artists AS Artist ON (Track.artist_id = Artist.id)
                WHERE 
                  Stat.date>='$desde' AND 
                  Stat.date <='$hasta' 
                GROUP BY track_id 
                ORDER BY count DESC
                LIMIT $n");
        
        //$ret = $this->findAll("Stat.date>='2007-10-14' AND Stat.date <='2007-12-16' group by Stat.track_id",array('*','sum(count) as count'),"Stat.count DESC",$n,0,1);
    
        return $ret;
    }
    
    
    function TopArtists ($desde, $hasta, $n = 10)
    {
        $ret = $this->query("SELECT Artist.name, sum(count) AS count 
                FROM
                (
                    SELECT sum(count) AS count, Track.artist_id 
                    FROM stats AS Stat 
                    LEFT JOIN tracks AS Track ON (Stat.track_id = Track.id) 
                    WHERE 
                      Stat.date>='$desde' AND 
                      Stat.date <='$hasta' 
                    GROUP BY Stat.track_id
                ) AS T 
                LEFT JOIN artists AS Artist ON (T.artist_id = Artist.id) 
                GROUP BY Artist.id
                ORDER BY count DESC
                LIMIT $n");
    
        return $ret;
    }
    
    
    function TopUsers ($desde, $hasta, $n = 10)
    {
        $ret = $this->query("SELECT User.name, User.username, sum(count) AS count 
                FROM 
                (
                    SELECT sum(count) AS count, Lyric.user_id 
                    FROM stats AS Stat 
                    LEFT JOIN tracks AS Track ON (Stat.track_id = Track.id) 
                    LEFT JOIN lyrics AS Lyric ON (Lyric.track_id = Track.id) 
                    WHERE 
                      Stat.date>='$desde' AND 
                      Stat.date <='$hasta'
                    GROUP BY Stat.track_id
                ) AS T 
                LEFT JOIN users AS User ON (T.user_id = User.id) 
                GROUP BY User.id
                ORDER BY count DESC
                LIMIT $n");
        
        //$ret = $this->findAll("Stat.date>='2007-10-14' AND Stat.date <='2007-12-16' group by Stat.track_id",array('*','sum(count) as count'),"Stat.count DESC",$n,0,1);
    
        return $ret;
    }
    
    function TopTracksByArtist($artist_id, $n = 10) {

        $ret = $this->query("SELECT sum(count) AS count, Track.name
                FROM stats AS Stat 
                LEFT JOIN tracks AS Track ON (Stat.track_id = Track.id) 
                LEFT JOIN artists AS Artist ON (Track.artist_id = Artist.id)
                WHERE 
                  Artist.id = '$artist_id' 
                GROUP BY track_id 
                ORDER BY count DESC
                LIMIT $n");
        
        //$ret = $this->findAll("Stat.date>='2007-10-14' AND Stat.date <='2007-12-16' group by Stat.track_id",array('*','sum(count) as count'),"Stat.count DESC",$n,0,1);
    
        return $ret;
    }
    
    function insert($track_id)
    {
        $date = gmdate('Y-m-d');
        $var = $this->find("track_id='{$track_id}' AND date='{$date}'",array('*'),'',-1);
        //pr($var);
        
        $data = array();
        
        $data['Stat'] = array('track_id' => $track_id, 
                                'date' => $date, 
                                'count' => $var['Stat']['count']+1 );
        if (!empty($var))
        {
            $data['Stat']['id'] = $var['Stat']['id'];
        }
        
        $this->save($data);
    
    
    }
}

?>
