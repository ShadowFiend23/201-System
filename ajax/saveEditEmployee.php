<?php 

    if( isset($_POST["presentAddress"]) && isset($_POST["presentContact"]) && isset($_POST["birthday"]) && 
        isset($_POST["placeBirth"]) && isset($_POST["gender"]) && isset($_POST["religion"]) &&
        isset($_POST["citizenship"]) && isset($_POST["civilStatus"]) && isset($_POST["sssNum"]) &&
        isset($_POST["tinNum"]) && isset($_POST["philhealthNum"]) && isset($_POST["hdmfNum"])
    ){
        require "../includes/connection.php";

        session_start();
        $employeeID     = $_POST["employeeID"];
        $presentAddress = $_POST["presentAddress"];
        $presentContact = $_POST["presentContact"];
        $homeAddress    = $_POST["homeAddress"];
        $homeContact    = $_POST["homeContact"];
        $birthday       = $_POST["birthday"];
        $placeBirth     = $_POST["placeBirth"];
        $gender         = $_POST["gender"];
        $religion       = $_POST["religion"];
        $citizenship    = $_POST["citizenship"];
        $civilStatus    = $_POST["civilStatus"];
        $height         = $_POST["height"];
        $weight         = $_POST["weight"];
        $hairColor      = $_POST["hairColor"];
        $eyeColor       = $_POST["eyeColor"];
        $dialectSpoken  = $_POST["dialectSpoken"];
        $mark           = $_POST["mark"];
        $sssNum         = $_POST['sssNum'];
        $tinNum         = $_POST["tinNum"];
        $philhealthNum  = $_POST["philhealthNum"];
        $hdmfNum        = $_POST["hdmfNum"];
        $error          = 0;
        $response       = array();

        $sql = $conn->prepare("UPDATE dbo.employee_info SET presentAddress=:presentAddress, presentContact=:presentContact,
            homeAddress=:homeAddress, homeContact=:homeContact, birthday=:birthday, placeBirth=:placeBirth, gender=:gender,
            religion=:religion, citizenship=:citizenship, civilStatus=:civilStatus, height=:height, weight=:weight,
            hairColor=:hairColor, eyeColor=:eyeColor, dialectSpoken=:dialectSpoken, mark=:mark, sssNum=:sssNum, tinNum=:tinNum,
            philhealthNum=:philhealthNum, hdmfNum=:hdmfNum WHERE employeeID=:employeeID");
        if(!$sql->execute([
            "presentAddress"    => $presentAddress,
            "presentContact"    => $presentContact,
            "homeAddress"       => $homeAddress,
            "homeContact"       => $homeContact,
            "birthday"          => $birthday,
            "placeBirth"        => $placeBirth,
            "gender"            => $gender,
            "religion"          => $religion,
            "citizenship"       => $citizenship,
            "civilStatus"       => $civilStatus,
            "height"            => $height,
            "weight"            => $weight,
            "hairColor"         => $hairColor,
            "eyeColor"          => $eyeColor,
            "dialectSpoken"     => $dialectSpoken,
            "mark"              => $mark,
            "sssNum"            => $sssNum,
            "tinNum"            => $tinNum,
            "philhealthNum"     => $philhealthNum,
            "hdmfNum"           => $hdmfNum,
            "employeeID"        => $employeeID
        ]))
            $error++;
        
         // FAMILY BACKGROUND
        if(isset($_POST["famFullName"]) && isset($_POST["famBirthday"]) && 
            isset($_POST["famOccupation"]) && isset($_POST["famRelation"]) && isset($_POST["famID"])){
            $famFullName    = $_POST["famFullName"];
            $famBirthday    = $_POST["famBirthday"];
            $famOccupation  = $_POST["famOccupation"];
            $famRelation    = $_POST["famRelation"];
            $famID          = $_POST["famID"];
            
            for($i=0; $i<count($famFullName); $i++){
                if(!empty($famFullName[$i]) && $famID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.family_background (employeeID,fullName,birthday,
                    occupation,relation) VALUES (:employeeID,:fullName,:birthday,:occupation,:relation)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "fullName"      => $famFullName[$i],
                        "birthday"      => $famBirthday[$i],
                        "occupation"    => $famOccupation[$i],
                        "relation"      => $famRelation[$i]
                    ]);
                }else if(!empty($famFullName[$i]) && $famID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.family_background SET fullName=:fullName, birthday=:birthday,
                     occupation=:occupation, relation=:relation WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "fullName"      => $famFullName[$i],
                        "birthday"      => $famBirthday[$i],
                        "occupation"    => $famOccupation[$i],
                        "relation"      => $famRelation[$i],
                        "id"            => $famID[$i],
                        "employeeID"    => $employeeID
                    ]);
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
    
            for($i=0; $i<count($depFullName); $i++){
                if(!empty($depFullName[$i]) && $depID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.dependents (employeeID,fullName,gender,birthday,relation)
                    VALUES (:employeeID,:fullName,:gender,:birthday,:relation)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "fullName"      => $depFullName[$i],
                        "gender"        => $depGender[$i],
                        "birthday"      => $depBirthday[$i],
                        "relation"      => $depRelation[$i]
                    ]);
                }else if(!empty($depFullName[$i]) && $depID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.dependents SET fullName=:fullName,gender=:gender,birthday=:birthday,relation=:relation WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "fullName"      => $depFullName[$i],
                        "gender"        => $depGender[$i],
                        "birthday"      => $depBirthday[$i],
                        "relation"      => $depRelation[$i],
                        "id"            => $depID[$i],
                        "employeeID"    => $employeeID
                    ]);
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
            
            for($i=0; $i<count($benFullName); $i++){
                if(!empty($benFullName[$i]) && $benID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.beneficiaries (employeeID,fullName,gender,birthday)
                     VALUES (:employeeID,:fullName,:gender,:birthday)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "fullName"      => $benFullName[$i],
                        "gender"        => $benGender[$i],
                        "birthday"      => $benBirthday[$i]
                    ]);
                }else if(!empty($benFullName[$i]) && $benID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.beneficiaries SET fullName=:fullName,gender=:gender,birthday=:birthday WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "fullName"      => $benFullName[$i],
                        "gender"        => $benGender[$i],
                        "birthday"      => $benBirthday[$i],
                        "id"            => $benID[$i],
                        "employeeID"    => $employeeID
                    ]);
                }
            }
        }

        // HOBBIES
        if(isset($_POST["hobCategory"]) && isset($_POST["hobDescription"]) && isset($_POST["hobID"])){
            $hobCategory    = $_POST["hobCategory"];
            $hobDescription = $_POST["hobDescription"];
            $hobID          = $_POST["hobID"];

            for($i=0; $i<count($hobCategory); $i++){
                if(!empty($hobCategory[$i]) && $hobID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.hobbies (employeeID,category,description)
                     VALUES (:employeeID,:category,:description)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "category"      => $hobCategory[$i],
                        "description"   => $hobDescription[$i],
                    ]);
                }else if(!empty($hobCategory[$i]) && $hobID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.hobbies SET category=:category, description=:description WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "category"      => $hobCategory[$i],
                        "description"   => $hobDescription[$i],
                        "id"            => $hobID[$i],
                        "employeeID"    => $employeeID
                    ]);
                }
            }
        }

        // SKILL
        if(isset($_POST["skillCategory"]) && isset($_POST["skillDescription"]) && isset($_POST["skillID"])){
            $skillCategory      = $_POST["skillCategory"];
            $skillDescription   = $_POST["skillDescription"];
            $skillID            = $_POST["skillID"];
            
            for($i=0; $i<count($skillCategory); $i++){
                if(!empty($skillCategory[$i]) && $skillID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.skills (employeeID,category,description)
                     VALUES (:employeeID,:category,:description)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "category"      => $skillCategory[$i],
                        "description"   => $skillDescription[$i],
                    ]);
                }else if(!empty($skillCategory[$i]) && $skillID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.skills SET category=:category, description=:description WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "category"      => $skillCategory[$i],
                        "description"   => $skillDescription[$i],
                        "id"            => $skillID[$i],
                        "employeeID"    => $employeeID
                    ]);
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
            
            
            for($i=0; $i<count($educSchoolName); $i++){
                if(!empty($educSchoolName[$i]) && $educID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.education (employeeID,lvl,schoolName,degree,schoolYear)
                     VALUES (:employeeID,:lvl,:schoolName,:degree,:schoolYear)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "lvl"           => $educLvl[$i],
                        "schoolName"    => $educSchoolName[$i],
                        "degree"        => $educDegree[$i],
                        "schoolYear"    => $educSchoolYear[$i]
                    ]);
                }else if(!empty($educSchoolName[$i]) && $educID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.education SET lvl=:lvl,schoolName=:schoolName,degree=:degree,schoolYear=:schoolYear WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "lvl"           => $educLvl[$i],
                        "schoolName"    => $educSchoolName[$i],
                        "degree"        => $educDegree[$i],
                        "schoolYear"    => $educSchoolYear[$i],
                        "id"            => $educID[$i],
                        "employeeID"    => $employeeID
                    ]);
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


             for($i=0; $i<count($examType); $i++){
                if(!empty($examType[$i]) && $examID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.exams (employeeID,examType,description,date,ratings,venue)
                     VALUES (:employeeID,:examType,:description,:date,:ratings,:venue)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "examType"      => $examType[$i],
                        "description"   => $examDescription[$i],
                        "date"          => $examDate[$i],
                        "ratings"       => $examRatings[$i],
                        "venue"         => $examVenue[$i]
                    ]);
                }else if(!empty($examFullName[$i]) && $examID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.exams SET examType=:examType, description=:description, date=:date, ratings=:ratings, venue=:venue WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "examType"      => $examType[$i],
                        "description"   => $examDescription[$i],
                        "date"          => $examDate[$i],
                        "ratings"       => $examRatings[$i],
                        "venue"         => $examVenue[$i],
                        "id"            => $examID[$i],
                        "employeeID"    => $employeeID
                    ]);
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


                for($i=0; $i<count($awardType); $i++){
                    if(!empty($awardType[$i]) && $awardID[$i] === "New"){
                        $sql = $conn->prepare("INSERT INTO dbo.awards (employeeID,awardType,description,date)
                         VALUES (:employeeID,:awardType,:description,:date)");
                        $sql->execute([
                            "employeeID"    => $employeeID,
                            "awardType"     => $awardType[$i],
                            "description"   => $awardDescription[$i],
                            "date"          => $awardDate[$i]
                        ]);
                    }else if(!empty($awardType[$i]) && $awardID[$i] !== "New"){
                        $sql = $conn->prepare("UPDATE dbo.awards SET awardType=:awardType,description=:description,date=:date WHERE id=:id AND employeeID=:employeeID");
                        $sql->execute([
                            "awardType"         => $awardType[$i],
                            "awardDescription"  => $awardDescription[$i],
                            "awardDate"         => $awardDate[$i],
                            "id"                => $awardID[$i],
                            "employeeID"        => $employeeID
                        ]);
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

            for($i=0; $i<count($jobEmployer); $i++){
                if(!empty($jobEmployer[$i]) && $jobID[$i] === "New"){
                    $sql = $conn->prepare("INSERT INTO dbo.experience (employeeID,employer,dateFrom,dateTo,position)
                     VALUES (:employeeID,:employer,:dateFrom,:dateTo,:position)");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "employer"      => $jobEmployer[$i],
                        "dateFrom"      => $jobDateFrom[$i],
                        "dateTo"        => $jobDateTo[$i],
                        "position"      => $jobPosition[$i]
                    ]);
                }else if(!empty($jobEmployer[$i]) && $jobID[$i] !== "New"){
                    $sql = $conn->prepare("UPDATE dbo.experience SET employer=:employer, dateFrom=:dateFrom, dateTo=:dateTo, position=:position WHERE id=:id AND employeeID=:employeeID");
                    $sql->execute([
                        "employer"      => $jobEmployer[$i],
                        "dateFrom"      => $jobDateFrom[$i],
                        "dateTo"        => $jobDateTo[$i],
                        "position"      => $jobPosition[$i],
                        "id"            => $educID[$i],
                        "employeeID"    => $employeeID
                    ]);
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

                for($i=0; $i<count($trainHost); $i++){
                    if(!empty($trainHost[$i]) && $trainID[$i] === "New"){
                        $sql = $conn->prepare("INSERT INTO dbo.trainings (employeeID,host,description,date,venue)
                         VALUES (:employeeID,:host,:description,:date,:venue)");
                        $sql->execute([
                            "employeeID"    => $employeeID,
                            "host"          => $trainHost[$i],
                            "description"   => $trainDescription[$i],
                            "date"          => $trainDate[$i],
                            "venue"         => $trainVenue[$i]
                        ]);
                    }else if(!empty($trainHost[$i]) && $trainID[$i] !== "New"){
                        $sql = $conn->prepare("UPDATE dbo.experience SET host=:host, description=:description, date=:date, venue=:venue WHERE id=:id AND employeeID=:employeeID");
                        $sql->execute([
                            "host"          => $trainHost[$i],
                            "description"   => $trainDescription[$i],
                            "date"          => $trainDate[$i],
                            "venue"         => $trainVenue[$i],
                            "id"            => $educID[$i],
                            "employeeID"    => $employeeID
                        ]);
                    }
                }
            
        }
        if($error == 0){
            $response["result"] = true;
            $response["msg"] = "Successfully Updated Employee";
        }else{
            $response["result"] = true;
            $response["msg"] = "Server Error. Try Again Later";
        }
        echo json_encode($response);
    }

?>