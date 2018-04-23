package authentication;

import java.sql.Connection;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.*;

import java.util.Random;

public class DBConnect {
    String URL = "jdbc:mysql://sqlserv:3306/skitter";
    public String createSession(String user){
        Random rand = new Random();
        String ALPHA_NUMERIC_STRING = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" +
                "abcdefghijlkmnopqrstuvwxyz0123456789";
        String sessionID = "";
        for(int i=0; i<30;i++){
            Integer curr = new Integer(rand.nextInt(62));
            sessionID = sessionID + ALPHA_NUMERIC_STRING.charAt(curr);
        }

        try{
            // check if user is registered
            Class.forName("com.mysql.jdbc.Driver");
            Connection con=DriverManager.getConnection(
                    URL,"root","password");
            PreparedStatement stmt = con.prepareStatement("select * from users where username=?");
            stmt.setString(1, user);
            ResultSet res = stmt.executeQuery();

            if (res.isBeforeFirst()) {
                // check if the user has a session
                PreparedStatement ses = con.prepareStatement("select * from sessions where username=?");
                ses.setString(1, user);
                ResultSet rs = ses.executeQuery();
                if (!rs.isBeforeFirst()) {
                    PreparedStatement ins = con.prepareStatement("insert into sessions (username,sessionid) "
                            + "values (?,?)");
                    ins.setString(1, user);
                    ins.setString(2, sessionID);
                    ins.executeUpdate();

                }
                else{
                    PreparedStatement rep = con.prepareStatement(
                            "replace into sessions VALUES (?,?)");
                    rep.setString(1, user);
                    rep.setString(2, sessionID);
                    rep.executeUpdate();
                }
            }
            else return "failed";
        }
        catch (Exception e){
            e.printStackTrace();
        }
        return sessionID;
    }

    public boolean getSession(String sessionID){
        try{
            Class.forName("com.mysql.jdbc.Driver");
            Connection con=DriverManager.getConnection(
                    URL,"root","password");
            PreparedStatement stmt = con.prepareStatement("select * from sessions where sessionid=?");
            stmt.setString(1, sessionID);
            ResultSet res = stmt.executeQuery();
            if (res.isBeforeFirst()){
                return true;
            }

        } catch (Exception e){
            e.printStackTrace();
            return false;
        }
        return false;
    }

    public String signup(String username, String email, String name) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection(
                    URL, "root", "password");
            PreparedStatement stmt = con.prepareStatement("select * from users where username=?");
            stmt.setString(1, username);
            ResultSet res = stmt.executeQuery();


            if (res.isBeforeFirst()) {
                return "Account already exists";
            }

            PreparedStatement create = con.prepareStatement(
                    "insert into users values (?,?,?)");
            create.setString(1, username);
            create.setString(2, email);
            create.setString(3, name);

            create.executeUpdate();

        } catch (Exception e){
            e.printStackTrace();
            return "fail";
        }
        return "success";
    }
}
