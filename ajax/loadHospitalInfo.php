
            <table class="table table-light table-hover border" id="employeeMedReqTable" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th class='border border-top border-bottom' style=""></th>
                        <th class='border border-top border-bottom' style="">Type</th>
                        <th class='border border-top border-bottom' style="">Date Requested</th>
                        <th class='border border-top border-bottom' style="">Amount</th>
                        <th class='border border-top border-bottom' style="">Used</th>
                        <th class='border border-top border-bottom' style="">Status</th>
                    </tr>
                </thead>
                <tbody id="employeeMedhapTableList">
                    <?php 
                        $count=1;
                        $sql = $conn->prepare("SELECT count(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID");
                        $sql->execute([
                            "employeeID"    => $employeeID
                        ]);
                        $row = $sql->fetch();
                        if($row["count"]){
                            $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE employeeID=:employeeID");
                            $sql->execute([
                                "employeeID"    => $employeeID
                            ]);
                            while($row = $sql->fetch()){
                                $sqlT = $conn->prepare("SELECT * FROM dbo.medhapType WHERE id=:id");
                                $sqlT->execute([ "id" => $row["medhapType"] ]);
                                $rowT = $sqlT->fetch();
                                $amount = "₱ ".number_format($row["amount"], 2);
                                $used = "₱ ".number_format($row["used"], 2);
                                echo "<tr>
                                    <td class='border border-top border-bottom'>".$count++."</td>
                                    <td class='border border-top border-bottom'>$rowT[name]</td>
                                    <td class='border border-top border-bottom'>$row[dateRequest]</td>
                                    <td class='border border-top border-bottom'>$amount</td>
                                    <td class='border border-top border-bottom'>$used</td>
                                    <td class='border border-top border-bottom'>$row[status]</td>
                                </tr>";
                            }
                        }else{
                            echo "<tr><td class='border border-top border-bottom' colspan='6'>No MED-HAP Request Found.</td></tr>";
                        }
                    
                    ?>
                </tbody>
            </table>