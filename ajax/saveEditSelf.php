<?php 
    require "../includes/connection.php";
    session_start();
    $employeeID     = $_SESSION["employeeID"];
    $status         = "Pending";
    $list           = array();
    $cancelStatus = "Cancelled";
    

    
    if(isset($_POST["famFullName"]) && isset($_POST["famBirthday"]) && 
    isset($_POST["famOccupation"]) && isset($_POST["famRelation"]) && isset($_POST["famID"])){
        
        
        $famFullName    = $_POST["famFullName"];
        $famBirthday    = $_POST["famBirthday"];
        $famOccupation  = $_POST["famOccupation"];
        $famRelation    = $_POST["famRelation"];
        $famID          = $_POST["famID"];
        array_push($list,"family");

        if(!empty($famFullName)){
            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.family_background WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.family_background SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($famFullName); $i++){
                if(!empty($famFullName[$i]) && $famID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.family_background (employeeID,fullName,birthday,
                    occupation,relation,status) VALUES (:employeeID,:fullName,:birthday,:occupation,:relation,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "fullName"      => $famFullName[$i],
                        "birthday"      => $famBirthday[$i],
                        "occupation"    => $famOccupation[$i],
                        "relation"      => $famRelation[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // DEPENDENTS
    if(isset($_POST["depFullName"]) && isset($_POST["depGender"]) && isset($_POST["depBirthday"]) && isset($_POST["depID"]) && isset($_POST["depRelation"])){
        $depFullName = $_POST["depFullName"];
        $depGender   = $_POST["depGender"];
        $depBirthday = $_POST["depBirthday"];
        $depID       = $_POST["depID"];
        $depRelation = $_POST["depRelation"];
        array_push($list,"dependents");

        if(!empty($depFullName)){
            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.dependents WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.dependents SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($depFullName); $i++){
                if(!empty($depFullName[$i]) && $depID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.dependents (employeeID,fullName,gender,birthday,relation,status)
                    VALUES (:employeeID,:fullName,:gender,:birthday,:relation,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "fullName"      => $depFullName[$i],
                        "gender"        => $depGender[$i],
                        "birthday"      => $depBirthday[$i],
                        "relation"      => $depRelation[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // BENEFICIARIES
    if(isset($_POST["benFullName"]) && isset($_POST["benGender"]) && 
        isset($_POST["benBirthday"]) && isset($_POST["benID"])){
        $benFullName = $_POST["benFullName"];
        $benGender   = $_POST["benGender"];
        $benBirthday = $_POST["benBirthday"];
        $benID       = $_POST["benID"];
        array_push($list,"beneficiaries");

        if(!empty($benFullName)){

            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.beneficiaries WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.beneficiaries SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($benFullName); $i++){
                if(!empty($benFullName[$i]) && $benID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.beneficiaries (employeeID,fullName,gender,birthday,status)
                    VALUES (:employeeID,:fullName,:gender,:birthday,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "fullName"      => $benFullName[$i],
                        "gender"        => $benGender[$i],
                        "birthday"      => $benBirthday[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // HOBBIES
    if(isset($_POST["hobCategory"]) && isset($_POST["hobDescription"]) && isset($_POST["hobID"])){
        $hobCategory    = $_POST["hobCategory"];
        $hobDescription = $_POST["hobDescription"];
        $hobID          = $_POST["hobID"];
        array_push($list,"hobbies");

        if(!empty($hobCategory)){
            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.hobbies WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.hobbies SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($hobCategory); $i++){
                if(!empty($hobCategory[$i]) && $hobID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.hobbies (employeeID,category,description,status)
                    VALUES (:employeeID,:category,:description,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "category"      => $hobCategory[$i],
                        "description"   => $hobDescription[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // SKILL
    if(isset($_POST["skillCategory"]) && isset($_POST["skillDescription"]) && isset($_POST["skillID"])){
        $skillCategory      = $_POST["skillCategory"];
        $skillDescription   = $_POST["skillDescription"];
        $skillID            = $_POST["skillID"];
        array_push($list,"skills");

        if(!empty($skillCategory)){
            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.dependents WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.dependents SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($skillCategory); $i++){
                if(!empty($skillCategory[$i]) && $skillID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.skills (employeeID,category,description,status)
                    VALUES (:employeeID,:category,:description,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "category"      => $skillCategory[$i],
                        "description"   => $skillDescription[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // EDUCATION
    if(isset($_POST["educLvl"]) && isset($_POST["educSchoolName"]) && isset($_POST["educDegree"]) && 
    isset($_POST["educSchoolYear"]) && isset($_POST["educID"])){
        $educLvl        = $_POST["educLvl"];
        $educSchoolName = $_POST["educSchoolName"];
        $educDegree     = $_POST["educDegree"];
        $educSchoolYear = $_POST["educSchoolYear"];
        $educID         = $_POST["educID"];
        array_push($list,"education");

        if(!empty($educSchoolName)){

            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.education WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.education SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($educSchoolName); $i++){
                if(!empty($educSchoolName[$i]) && $educID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.education (employeeID,lvl,schoolName,degree,schoolYear,status)
                    VALUES (:employeeID,:lvl,:schoolName,:degree,:schoolYear,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "lvl"           => $educLvl[$i],
                        "schoolName"    => $educSchoolName[$i],
                        "degree"        => $educDegree[$i],
                        "schoolYear"    => $educSchoolYear[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // LICENSURE / EXAMS
    if(isset($_POST["examType"]) && isset($_POST["examDescription"]) && isset($_POST["examDate"])
    && isset($_POST["examRatings"]) && isset($_POST["examVenue"]) && isset($_POST["examID"])){
        $examType          = $_POST["examType"];
        $examDescription   = $_POST["examDescription"];
        $examDate          = $_POST["examDate"];
        $examRatings       = $_POST["examRatings"];
        $examVenue         = $_POST["examVenue"];
        $examID            = $_POST["examID"];
        array_push($list,"exams");

        if(!empty($examType)){

            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.exams WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.exams SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($examType); $i++){
                if(!empty($examType[$i]) && $examID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.exams (employeeID,examType,description,date,ratings,venue,status)
                    VALUES (:employeeID,:examType,:description,:date,:ratings,:venue.:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "examType"      => $examType[$i],
                        "description"   => $examDescription[$i],
                        "date"          => $examDate[$i],
                        "ratings"       => $examRatings[$i],
                        "venue"         => $examVenue[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }

    // AWARDS
    if(isset($_POST["awardType"]) && isset($_POST["awardDescription"]) && 
    isset($_POST["awardDate"]) && isset($_POST["awardID"])){
        $awardType        = $_POST["awardType"];
        $awardDescription = $_POST["awardDescription"];
        $awardDate        = $_POST["awardDate"];
        $awardID          = $_POST["awardID"];
        array_push($list,"awards");

        if(!empty($awardType)){

            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.awards WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.awards SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($awardType); $i++){
                if(!empty($awardType[$i]) && $awardID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.awards (employeeID,awardType,description,date,status)
                    VALUES (:employeeID,:awardType,:description,:date,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "awardType"     => $awardType[$i],
                        "description"   => $awardDescription[$i],
                        "date"          => $awardDate[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }


    // JOB EXPERIENCE
    if(isset($_POST["jobEmployer"]) && isset($_POST["jobDateFrom"]) && 
    isset($_POST["jobDateTo"]) && isset($_POST["jobPosition"]) && isset($_POST["jobID"])){
        $jobEmployer = $_POST["jobEmployer"];
        $jobDateFrom = $_POST["jobDateFrom"];
        $jobDateTo   = $_POST["jobDateTo"];
        $jobPosition = $_POST["jobPosition"];
        $jobID       = $_POST["jobID"];
        array_push($list,"experience");

        if(!empty($jobEmployer)){
            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.experience WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.experience SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($jobEmployer); $i++){
                if(!empty($jobEmployer[$i]) && $jobID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.experience (employeeID,employer,dateFrom,dateTo,position,status)
                    VALUES (:employeeID,:employer,:dateFrom,:dateTo,:position,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "employer"      => $jobEmployer[$i],
                        "dateFrom"      => $jobDateFrom[$i],
                        "dateTo"        => $jobDateTo[$i],
                        "position"      => $jobPosition[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }


    // TRAININGS / SEMINAR
    if(isset($_POST["trainDescription"]) && isset($_POST["trainHost"]) && 
    isset($_POST["trainDate"]) && isset($_POST["trainVenue"]) && isset($_POST["trainID"])){
        $trainDescription   = $_POST["trainDescription"];
        $trainHost          = $_POST["trainHost"];
        $trainDate          = $_POST["trainDate"];
        $trainVenue         = $_POST["trainVenue"];
        $trainID            = $_POST["trainID"];
        array_push($list,"trainings");

        if(!empty($trainDescription)){
            $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.trainings WHERE employeeID=:employeeID and status=:status");
            $sql->execute([
                "employeeID"    => $employeeID,
                "status"        => $status
            ]);
            $row = $sql->fetch();
            if($row["count"] > 0){
                $sql = $conn->prepare("UPDATE dbo.trainings SET status=:status WHERE employeeID=:employeeID");
                $sql->execute([
                    "status"        => $cancelStatus,
                    "employeeID"    => $employeeID
                ]);
            }

            for($i=0; $i<count($trainHost); $i++){
                if(!empty($trainHost[$i]) && $trainID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.trainings (employeeID,host,description,date,venue,status)
                    VALUES (:employeeID,:host,:description,:date,:venue,:status)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "host"          => $trainHost[$i],
                        "description"   => $trainDescription[$i],
                        "date"          => $trainDate[$i],
                        "venue"         => $trainVenue[$i],
                        "status"        => $status
                    ]);
                }
            }
        }
    }
    if($error == 0){
        $list = serialize($list);
        $sql = $conn->prepare("INSERT INTO dbo.profiles (employeeID,list,status) VALUES (:employeeID,:list,:status)");
        if($sql->execute([
            "employeeID"    => $employeeID,
            "list"          => $list,
            "status"        => $status
        ])){
            $response["result"] = true;
            $response["msg"] = "Successfully Updated Info. Waiting For Admin Approval.";
        }else{
            $response["result"] = true;
            $response["msg"] = "Server Error. Try Again Later";
        }
        
    }else{
        $response["result"] = true;
        $response["msg"] = "Server Error. Try Again Later";
    }
    echo json_encode($response);

?>